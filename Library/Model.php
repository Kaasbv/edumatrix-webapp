<?php
class Model {
  public static $_tableName;
  public $_isNew = true;

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
      if(substr($property->name, 0, 1) !== "_" && isset($object[$property->name])){
        if($property->isProtected() || $property->isPrivate()){
          $property->setAccessible(true);
        }

        $property->setValue($instance, $object[$property->name]);
      }
    }
    
    
    $isNewProperty = $reflectionClass->getProperty("_isNew");
    $isNewProperty->setValue($instance, false);

    return $instance;
  }

  public static function getAll($where, $limit = false){
    $items = DatabaseConnection::select(static::$_tableName, [], $where, $limit);

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
}
?>