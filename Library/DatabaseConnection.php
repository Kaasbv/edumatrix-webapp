<?php
  class DatabaseConnection {
    public static $credentialPath = __DIR__ . "/../credentials.json";
    public static $connection;

    public static function startConnection(){
      $credentials = self::grabCredentials();
      self::$connection = new mysqli(
        $credentials->databaseHost,
        $credentials->databaseUsername,
        $credentials->databasePassword,
        $credentials->databaseName
      );

      if(self::$connection->connect_errno){
        throw new Exception("Failed to connect to database", 500);
      }
    }

    public static function select($table, $select = [], $where = [], $limit = false, $joins = [], $groupBy = false){
      $preparedValues = $preparedTypes = [];
      $selectPart = count($select) === 0 ? "*" : implode(",", $select);
      $query = "SELECT {$selectPart} FROM {$table}";
      
      //generate joins
      if(count($joins) > 0){
        foreach ($joins as $join) {
          $primaryKey = $join["primaryKey"] ?? "id";
          $primaryTableName = $join["primaryTableName"] ?? $table;
          $query .= " LEFT JOIN {$join["tableName"]} on `{$primaryTableName}`.`{$primaryKey}` = `{$join["tableName"]}`.`{$join["foreignKey"]}`";
        }
      }

      //Generate where
      if(count($where) > 0){
        $query .= " WHERE ";

        $whereKeys = array_keys($where);
        for($index = 0; $index < count($whereKeys); $index++){
          $key = $whereKeys[$index];
          $value = $where[$key];
          
          if($index != 0) $query .= " AND ";
          $query .= "{$key} = ?";
  
          $preparedValues[] = $value;
          $preparedTypes[] = self::getDataType($value);
        }
      }


      //Add values
      if($groupBy){
        $query .= " GROUP BY " . $groupBy;
      }

      if($limit){
        $query .= " LIMIT ?";
        $preparedValues[] = $limit;
        $preparedTypes[] = "i";
      }


      if(count($preparedValues) === 0 && count($preparedTypes) === 0){
        
      }else{
        return self::runPreparedQuery($query, $preparedValues, $preparedTypes);
      }
    }

    public static function insert($table, $data){
      $preparedValues = $preparedTypes = [];

      $keys = array_keys($data);
      $values = array_values($data);

      $query = "INSERT INTO {$table} (" . implode(",", $keys) . ") VALUES (" . implode(",", array_fill(0, count($keys), "?")) . ")";

      //Generate prepared statement
      foreach ($values as $value) {
        $preparedValues[] = $value;
        $preparedTypes[] = self::getDataType($value);
      }

      return self::runPreparedQuery($query, $preparedValues, $preparedTypes);
    }

    public static function update($table, $data, $where){
      $preparedValues = $preparedTypes = [];
      $query = "UPDATE {$table} SET ";

      //Generate set statements
      $dataKeys = array_keys($data);
      for($index = 0; $index < count($dataKeys); $index++){
        $key = $dataKeys[$index];
        $value = $data[$key];
        
        if($index != 0) $query .= ",";
        $query .= "{$key} = ?";

        $preparedValues[] = $value;
        $preparedTypes[] = self::getDataType($value);
      }

      $query .= " WHERE ";

      //Generate where
      $whereKeys = array_keys($where);
      for($index = 0; $index < count($whereKeys); $index++){
        $key = $whereKeys[$index];
        $value = $where[$key];
        
        if($index != 0) $query .= " AND ";
        $query .= "{$key} = ?";

        $preparedValues[] = $value;
        $preparedTypes[] = self::getDataType($value);
      }

      return self::runPreparedQuery($query, $preparedValues, $preparedTypes);
    }

    private static function runPreparedQuery($query, $values, $types){
      $statement = self::$connection->prepare($query);
      if(!$statement) throw new Exception("Invalid prepared query entered", 500);
      
      $statement->bind_param(implode($types), ...$values);
      if(!$statement) throw new Exception("Failed to bind params", 500);

      $execution = $statement->execute();
      if($execution){
        $result = $statement->get_result();
        if($result){
          $response = $result->fetch_all(MYSQLI_ASSOC);
        }
      }else{
        throw new Exception("Query failed!" . $statement->error, 500);
      }

      $statement->close();

      return $response ?? [];
    }

    private static function getDataType($var){
      $type = gettype($var);
      if(in_array($type, ["boolean", "integer"])){
        return "i";
      }else if($type === "double"){
        return "d";
      }else if($type === "string"){
        return "s";
      }
    }

    private static function grabCredentials(){
      if(isset($_ENV["IS_SERVER"]) && $_ENV["IS_SERVER"] === "true"){
        return (object)[
          "databaseUsername" => $_ENV["databaseUsername"],
          "databasePassword" => $_ENV["databasePassword"],
          "databaseName" => $_ENV["databaseName"],
          "databaseHost" => $_ENV["databaseHost"],
        ];
      }else{
        if(!is_file(self::$credentialPath)){
          throw new Exception("Credential file missing", 500);
        }
        $content = file_get_contents(self::$credentialPath);
        $parsedContent = json_decode($content);
  
        if($parsedContent === null){
          throw new Exception("Credential file invalid json", 500);
        }
  
        return $parsedContent;
      }
    }
  }
?>