<?
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

    DatabaseConnection::update(static::$_tableName, $updateObject, ["id" => $this->id]);
  }

  public static function getOne($where){
    [$response] = DatabaseConnection::select(static::$_tableName, [], $where);

    $reflectionClass = new ReflectionClass(get_called_class());
    $properties = $reflectionClass->getProperties();
    $propertyNames = [];
    //get names
    foreach ($properties as $property) {
      if(substr($property->name, 0, 1) !== "_"){
        $propertyNames[] = $property->name;
      }
    }

    $instance = $reflectionClass->newInstanceWithoutConstructor();

    //fill object
    foreach ($response as $key => $value) {
      $private = false;
      if(in_array($key, $propertyNames)){
        $reflectionProperty = $reflectionClass->getProperty($key);
        if($reflectionProperty->isProtected()){
          $private = true;
          $reflectionProperty->setAccessible(true);
        }

        $reflectionProperty->setValue($instance, $value);
        if($private){
          $reflectionProperty->setAccessible(false);
        }
      }
    }

    return $instance;
  }
}
?>