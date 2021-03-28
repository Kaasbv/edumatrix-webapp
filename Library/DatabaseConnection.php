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

    public static function closeConnection(){
      self::$connection->close();
    }

    public static function runPreparedQuery($query, $values, $types){
      $statement = self::$connection->prepare($query);
      if(!$statement) {
        throw new Exception(self::$connection->error, 500);
      }
      
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