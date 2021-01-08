<?php
class Model {
  public static $_tableName;
  public $_isNew = true;
  protected static $_joins = [
    // [ ***VOORBEELD***
    //   "primaryKey" => "", //key in onze table standaard id bijvoorbeeld van klas
    //   "foreignKey" => "modelname_id", //matcht met deze key in koppel tabel bijvoorbeeld klas_id
    //   "tableName" => "modelnamekoppeltabel", //koppeltabel
    //   "modelName" => "modelname" //evt naam voor koppelen tabel
    // ]
  ];

  public function save(){
    $properties = get_object_vars($this);
    $filteredProperties = [];
    //filter
    foreach ($properties as $property => $propertyValue) {
      if(substr($property, 0, 1) !== "_"){
        $filteredProperties[] = $property;
      }
    }

    $updateObject = [];

    foreach ($filteredProperties as $filteredProperty) {
      $updateObject[$filteredProperty] = $this->$filteredProperty;
    }

    if($this->_isNew){
      unset($updateObject["id"]);
      DatabaseConnection::insert(static::$_tableName, $updateObject);
    }else{
      DatabaseConnection::update(static::$_tableName, $updateObject, ["id" => $this->id]);
    }
  }

  private static function createInstanceFromObject($object){
    $reflectionClass = new ReflectionClass(get_called_class());
    $properties = $reflectionClass->getProperties();

    $instance = $reflectionClass->newInstanceWithoutConstructor();
    foreach ($properties as $property) {
      $propertyName = strtoupper(self::camelToSnake($property->name));
      // echo $propertyName . "\n";
      if(substr($property->name, 0, 1) !== "_" && isset($object[$propertyName])){
        if($property->isProtected() || $property->isPrivate()){
          $property->setAccessible(true);
        }

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
          if(self::camelToSnake($property->name) === strtolower($key)){
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
      [],
      static::generateWhere($where),
      $limit,
      static::$_joins
    );

    $response = [];
    foreach ($items as $item) {      
      $instance = self::createInstanceFromObject($item);
      $response[] = $instance;
    }

    return $response;
  }

  public static function getOne($where){
    $items = self::getAll($where, 1);
    return count($items) !== 0 ? $items[0] : false;
  }

  private static function camelToSnake($input){
    return strtolower(preg_replace(['/([a-z\d])([A-Z])/', '/([^_])([A-Z][a-z])/'], '$1_$2', $input));
  }

  private static function snakeToCamel($input){
    return lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $input))));
  }

}
?>