<?php
class Model {
  public static $_tableName;
  public $_isNew = true;
  public static $_inheritanceColumn;
  public static $_primaryKey = "id";
  
  protected static $_joins = [
    // [ ***VOORBEELD***
    //   "primaryKey" => "", //key in onze table standaard id bijvoorbeeld van klas
    //   "foreignKey" => "modelname_id", //matcht met deze key in koppel tabel bijvoorbeeld klas_id
    //   "tableName" => "modelnamekoppeltabel", //koppeltabel
    //   "primaryTableName" => "modelnametabel", //tabel waarvandaan komt 
    //   "modelName" => "modelname" //evt naam voor koppelen tabel
    // ]
  ];

  private function getObjectVarsFromClass($className){
    $reflectionClass = new ReflectionClass(get_called_class());
    $properties = $reflectionClass->getProperties();

    $classProperties = [];
    foreach ($properties as $property) {
      if($property->class === $className && substr($property->name, 0, 1) !== "_")
        $classProperties[] = $property->name;
    }

    return $classProperties;
  }

  public function save(){
    $classes = [get_called_class(), ...array_values(class_parents(get_called_class()))];
    //Remove Model parent
    array_pop($classes);
    //Save per class
    foreach ($classes as $key => $className) {
      if($key === 0){
        $this->saveClass($className);
      }else{
        $primaryKeyValue = $this->{self::snakeToCamel($classes[$key - 1]::$_inheritanceColumn)};
        $this->saveClass($className, $primaryKeyValue);
      }
    }
  }

  private function saveClass($className, $primaryKeyValue = false){
    $properties = $this->getObjectVarsFromClass($className);

    $updateObject = [];
    foreach ($properties as $property) {
      if(isset($this->$property)){
        $updateObject[strtoupper(self::camelToSnake($property))] = $this->$property;
      }
    }

    unset($updateObject[strtoupper($className::$_primaryKey)]);
    if($this->_isNew){
      $insertId = DatabaseConnection::insert($className::$_tableName, $updateObject);
      $this->{static::$_primaryKey} = $insertId;
      return $insertId;
    }else{
      DatabaseConnection::update($className::$_tableName, $updateObject, [$className::$_primaryKey => $primaryKeyValue ? $primaryKeyValue : $this->id]);
    }
  }

  private static function createInstanceFromObject($object){
    $reflectionClass = new ReflectionClass(get_called_class());
    $properties = $reflectionClass->getProperties();
    $instance = $reflectionClass->newInstanceWithoutConstructor();

    foreach ($properties as $property) {
      $propertyName = strtoupper(self::camelToSnake($property->name));
      if(substr($property->name, 0, 1) !== "_" && isset($object[$propertyName])){
        if($property->isProtected() || $property->isPrivate())
          $property->setAccessible(true);

        $property->setValue($instance, $object[$propertyName]);
      }
    }
    
    
    $isNewProperty = $reflectionClass->getProperty("_isNew");
    $isNewProperty->setValue($instance, false);

    return $instance;
  }

  private static function generateWhere($where){
    $reflectionClass = new ReflectionClass(get_called_class());
    $properties = $reflectionClass->getProperties();

    foreach($where as $whereKey => $whereValue){
      foreach ($properties as $property) {
        if(gettype($whereValue) !== "array"){
          $key = $whereKey;
          $value = $whereValue;
        }else{
          [$key,, $value] = $whereValue;
        }

        if(!str_contains($key, ".")){
          if(strtolower(self::camelToSnake($property->name)) === strtolower($key)){
            $tableName = static::$_tableName;
            if(gettype($whereValue) !== "array"){
              $where["`{$tableName}`.`{$key}`"] = $value;
              unset($where[$key]);
            }else{
              $where[$whereKey][0] = "`{$tableName}`.`{$key}`";
            }
          }
        }
      }
    }

    return $where;
  }

  public static function getAll($where, $limit = false){
    
    $items = DatabaseConnection::select(
      static::$_tableName,
      self::generateSelect(),
      self::generateWhere($where),
      $limit,
      self::generateJoins(),
      "`" . static::$_tableName . "`.`" . static::$_primaryKey ."`" //aaaaaa set groupby to primarykey
    );

    $response = [];
    foreach ($items as $item) {      
      $instance = self::createInstanceFromObject($item);
      $response[] = $instance;
    }

    return $response;
  }

  private static function generateSelect(){
    $map = [];
    $classes = array_keys(class_parents(get_called_class()));
    array_unshift($classes, get_called_class());

    foreach(array_reverse($classes) as $class){
      if(!$class !== "Model"){
        $reflectionClass = new ReflectionClass($class);
        $properties = $reflectionClass->getProperties();
    
        foreach ($properties as $property) {
          $propertyName = strtoupper(self::camelToSnake($property->name));
          if(substr($property->name, 0, 1) !== "_" && $property->class === $class){
            $map[$propertyName] = $class::$_tableName;
          }
        }
      }
    }
    
    //Change to sql columns
    array_walk($map, fn(&$table, $column) => $table = "`{$table}`.`{$column}`");
    return array_values($map);
  }

  private static function generateJoins(){
    $joins = [];
    $className = get_called_class();
    //Add own joins
    array_push($joins, ...$className::$_joins);
    //Add parent joins
    $parentClassName = get_parent_class($className);
    if($parentClassName && $parentClassName !== "Model"){
      //Add parent
      $joins[] = [
        "foreignKey" => $className::$_primaryKey,
        "primaryKey" => $className::$_inheritanceColumn,
        "tableName" => $parentClassName::$_tableName,
        "primaryTableName" => $className::$_tableName
      ];
      //Add recursive own joins
      array_push($joins, ...$parentClassName::generateJoins());
    }

    return $joins;
  }

  public static function getOne($where = []){
    $items = self::getAll($where, 1);
    return count($items) !== 0 ? $items[0] : null;
  }

  private static function camelToSnake($input){
    return preg_replace(['/([a-z\d])([A-Z])/', '/([^_])([A-Z][a-z])/'], '$1_$2', $input);
  }

  private static function snakeToCamel($input){
    return lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ',strtolower($input)))));
  }
}
//backwards compatability
if(!function_exists("str_contains")){
  function str_contains($haystack, $needle){
    return strpos($haystack, $needle) !== false;
  }
}
?>

