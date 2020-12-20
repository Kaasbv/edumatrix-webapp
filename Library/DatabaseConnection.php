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

    public static function update($table, $data, $where){
      $query = "UPDATE {$table} SET ";

      foreach ($data as $key => $value) {
        $query .= "${$key} = ?";

      }
    }

    private static function grabCredentials(){
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
?>