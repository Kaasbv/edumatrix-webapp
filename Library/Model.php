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

  public function getObjectVarsFromClass(){
    $className = get_called_class();
    $reflectionClass = new ReflectionClass($className);
    $properties = $reflectionClass->getProperties();

    $classProperties = [];
    foreach ($properties as $property) {
      if($property->class === $className && substr($property->name, 0, 1) !== "_")
        $classProperties[] = $property->name;
    }

    return $classProperties;
  }

  public function save(){
    $properties = $this->getObjectVarsFromClass();

    $updateObject = [];
    foreach ($properties as $property) {
      if($this->$property != null){
        $updateObject[strtoupper(self::camelToSnake($property))] = $this->$property;
      }
    }

    unset($updateObject["id"]);
    if($this->_isNew){
      DatabaseConnection::insert(static::$_tableName, $updateObject);
    }else{
      DatabaseConnection::update(static::$_tableName, $updateObject, ["id" => $this->id]);
    }

    //TODO: Add parent inheritance saving
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

  public static function generateWhere($where){
    $reflectionClass = new ReflectionClass(get_called_class());
    $properties = $reflectionClass->getProperties();

    foreach($where as $key => $value){
      if(!str_contains($key, ".")){
        foreach ($properties as $property) {
          if(strtolower(self::camelToSnake($property->name)) === strtolower($key)){
            $tableName = static::$_tableName;
            $where["`{$tableName}`.`{$key}`"] = $value;
            unset($where[$key]);
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

  public static function generateSelect(){
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

  public static function generateJoins(){
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

  public static function getOne($where){
    $items = self::getAll($where, 1);
    return count($items) !== 0 ? $items[0] : false;
  }

  private static function camelToSnake($input){
    return preg_replace(['/([a-z\d])([A-Z])/', '/([^_])([A-Z][a-z])/'], '$1_$2', $input);
  }

}
?>