<?php

/**
* GESTIONNAIRE de la Base de Donnée :
*
* - new Bdd();				: Creer l'objet Bdd()
*
* - ->getClassMethods($em)  : Retourne les noms des méthodes de la classe Bdd()
* - ->showBdd()				: Retourne la ou les base(s) de donnée(s) qui existent sur cette instance MemSQL
* - ->showTable()			: Retourne la ou les table(s) contenu dans la bdd
* - ->setTable($name) 		: Définit le nom de la table
* - ->descTable()			: Retourne les champs contenu(s) dans la table
*
* - ->find($id)				: Récupère une ligne de la table en fonction d'un identifiant
* - ->findAll() 		 	: Récupère tout le contenu de la table définit
* | ->findAll($orderBy = "", $orderDir = "ASC", $limit = null, $offset = null)
*
* - ->primaryKey()			: Retourne la clé primaire de la table
* - ->columnCount()			: Retourne le nombre de colonnes dans le jeu de résultats
* -	->rowCount()			: Retourne le nombre de lignes de la table
* | ->rowCount($row, $data) : Retourne le nombre de lignes affectées par le dernier appel à la fonction 
* - ->getColumnMeta($i)		: Retourne les métadonnées pour une colonne d'un jeu de résultats
* - ->lastInsertId() 		: Retourne l'id de la derniere ligne inserer (apres un insert) 
* - ->stylish($arrayFromSelect) : Affiche un $array d'un find($id) ou d'un findAll() dans un <table> html
*
* Gestion des erreurs :
* - Si la bdd n est pas correct
* - Si la table n'a pas été déclarée
* - Si la table n'a pas été trouvée ( avec un showTable() en plus ;) )
*/
class Bdd {

	private static $_nom_base   = "repertoire"; // repertoire
    private static $_pass       = "";
    private static $_username   = "root";
    private static $_host       = "localhost";
    private static $_port       = "";
    private static $_charset    = "utf8";

    protected $table;


    /**
    * Connexion a la bdd
    * @return: try->un pdo statement / catch->une erreur
    */
    public static function connexion_base()
    {
        $dsn = "mysql:host=".self::$_host.
                ";dbname="  .self::$_nom_base.
                ";port="    .self::$_port.
                ";charset=" .self::$_charset;
        try 
        {
            $bdd = new PDO($dsn, self::$_username, self::$_pass, array(
            	PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //on récupère nos données en array associatif par défaut
            	PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING //on affiche les erreurs.
            ));
            return $bdd;
        } 
        catch (PDOException $exception) 
        {
            //mail('mail@hotmail.com', 'PDOException', $exception->getMessage());
            die ('Erreur de connexion : ' . $exception->getMessage());
        }
    }


    /**
    * Retourne les noms des méthodes de la classe Bdd()
    * @return Array (tableau associatif)
    */
    public function getClassMethods($em)
    {
    	$content = get_class_methods($em);
    	$i = 0;
    	foreach ($content as $key => $value) {
    		$newContent[$i] = array("Méthodes de la classe Bdd()" => $value);
    		$i++;
    	}
    	return $newContent;
    }


    /**
    * Retourne la ou les base(s) de donnée(s) qui existent sur cette instance MemSQL
    * @return Array (tableau associatif)
    */
    public function showBdd()
    {
    	$bdd = self::connexion_base();
		$pdo_stmt = $bdd->query('SHOW DATABASES');
		$content = $pdo_stmt->fetchAll();
		return $content;
    }


    /**
	* Retourne la ou les table(s) contenu dans la bdd
	* @return Array (tableau associatif)
	*/
	public function showTable()
	{
		$bdd = self::connexion_base();
		$pdo_stmt = $bdd->query('SHOW TABLES');
		$content = $pdo_stmt->fetchAll();
		$i = 0;
		foreach ($content as $value) {
			foreach ($value as $key => $val) {
				$newContent[$i] = array(
					"Table(s) disponible(s) dans la base de données : ".self::$_nom_base => $val 
				);
				$i++;
			}
		}
		return $newContent;
	}


    /**
    * Définit le nom de la table et vérifie si elle existe
    * @param: $table ("nomDeLaTable")
    */
    public function setTable($name)
	{
		self::verifTable($name);
		$this->table = $name;
		return $this;
	}


	/**
	* Retourne le nom de la table
	* @return: (String) le nom de la table
	*/
	public function getTable()
	{
		return $this->table;
	}


	/**
    * Retourne les champs contenu(s) dans la table
	* @return: (String) le nom des champs dans un table html
    */
    /*
    public function champsTable()
    {
    	self::tableExiste();
		$bdd = self::connexion_base();
		$pdo_stmt = $bdd->query("SELECT * FROM $this->table");
		$content = "<table border='1'><tr><th>Champs disponible(s) dans la table : ".$this->table."</th></tr>";
		for($i=0; $i < $pdo_stmt->columnCount(); $i++)
		{
			$pk = (in_array("primary_key", $pdo_stmt->getColumnMeta($i)['flags'])) ? " <strong style='color:#f00;'>{ PK }</strong> ": ""; 
			$metaName[$i] = $pdo_stmt->getColumnMeta($i)['name'];
			$content .= "<tr><td>".$metaName[$i]."$pk</td></tr>";
		}
		$content .= "</table>";
		echo $content;
    }
    */


    /**
    * function alternative à champsTable() et plus courte !!
    * Retourne les champs contenu(s) dans la table
    * @return Array (les champs contenu(s) dans la table)
    */
    public function descTable()
    {
    	self::tableExiste();
		$bdd = self::connexion_base();
		$pdo_stmt = $bdd->query("DESC $this->table");
		$result = $pdo_stmt->fetchAll();
		
		return $result;
    }


    /**
    * Vérifie la véracité du @param $table
    * @return: message d'erreur si n'existe pas
    */
    private function verifTable($table)
    {
    	$bdd = self::connexion_base();
		$pdo_stmt = $bdd->query('SHOW TABLES FROM '.self::$_nom_base.' LIKE "'.$table.'"');
		$result = $pdo_stmt->rowCount();
		if ($result == 0) {
			$this->stylish($this->showTable());
			echo ("La table '".$table."' n'a pas été trouvée, vérifier la syntaxe !");
		}
    }


    /**
    * Vérifie si une table a été déclarée
    * @return: message d'erreur si aucune table déclarée
    */
    private function tableExiste()
    {
    	$table = $this->table;
    	if ($table == NULL) {
    		die("Aucune table déclarée, ajouter en une avec \$votreObjet&minus;&gt;setTable('NomDeLaTable');");
    	}
    }


    /**
    * Récupère une ligne de la table en fonction d'un identifiant
    * @param $id
    * @return array Les données sous forme de tableau associatif
    */
    public function find($id){
    	if (!is_numeric($id)){
			return false;
		}
    	self::tableExiste();
		$bdd = self::connexion_base();
		$pdo_stmt = $bdd->prepare("SELECT * FROM $this->table WHERE ".self::primaryKey()." = :id");
		$pdo_stmt->bindParam(':id', $id, PDO::PARAM_STR);
		$pdo_stmt->execute();
		$result = $pdo_stmt->fetchAll();
		
		return $result;
    }


    /**
    * Récupère toutes les lignes de la table (Merci W)
    * @param   $orderBy La colonne en fonction de laquelle trier
	* @param   $orderDir La direction du tri, ASC ou DESC
	* @param   $limit Le nombre maximum de résultat à récupérer
	* @param   $offset La position à partir de laquelle récupérer les résultats
	* @return array Les données sous forme de tableau multidimensionnel
    */
    public function findAll($orderBy = "", $orderDir = "ASC", $limit = null, $offset = null)
    {
    	self::tableExiste();
		$bdd = self::connexion_base();
		$sql = "SELECT * FROM ".$this->table;
		if (!empty($orderBy)){

			//sécurisation des paramètres, pour éviter les injections SQL
			if(!preg_match("#^[a-zA-Z0-9_$]+$#", $orderBy)){
				die("invalid orderBy param pour la requete findAll()");
			}
			$orderDir = strtoupper($orderDir);
			if($orderDir != "ASC" && $orderDir != "DESC"){
				die("invalid orderDir param pour la requete findAll()");
			}
			if ($limit && !is_int($limit)){
				die("invalid limit param pour la requete findAll()");
			}
			if ($offset && !is_int($offset)){
				die("invalid offset param pour la requete findAll()");
			}

			$sql .= " ORDER BY $orderBy $orderDir";
			if ($limit){
				$sql .= " LIMIT $limit";
				if ($offset){
					$sql .= " OFFSET $offset";
				}
			}
		}
		$pdo_stmt = $bdd->query($sql);
		$content = $pdo_stmt->fetchAll(); // PDO::FETCH_ASSOC par default demander dans la connexion bdd ;)
		return $content;
    }


    /**
    * Efface une ligne en fonction de son identifiant
    * @param: ($id) L'identifiant de la ligne à effacer
    * @return: (bool) valeur de retour de la méthode execute()
    */
    public function remove($id)
    {
    	if (!is_numeric($id)){
			return false;
		}
		self::tableExiste();
		$bdd = self::connexion_base();		
		$pdo_stmt = $bdd->prepare("DELETE FROM $this->table WHERE ".self::primaryKey()." = :id");
		$pdo_stmt->bindParam(":id", $id, PDO::PARAM_STR);
		$result = $pdo_stmt->execute();
		return $result;
    }


    /**
    *
    */
    public function replace(array $data)
    {
    	self::tableExiste();
		$bdd = self::connexion_base();

    	$colNames = array_keys($data);
		$colNamesString = implode(", ", $colNames);

		$sql = "REPLACE INTO " . $this->table . " ($colNamesString) VALUES (";
		foreach($data as $key => $value){
			$sql .= ":$key, ";
		}
		$sql = substr($sql, 0, -2);
		$sql .= ")";
		var_dump($sql);

		$pdo_stmt = $bdd->prepare($sql);
		foreach($data as $key => $value){
			$value = htmlentities($value, ENT_QUOTES); // anti injection SQL
			$pdo_stmt->bindValue(":".$key, $value);
		}
		$result = $pdo_stmt->execute();
		return $result;
    }


    /**
    * Retourne le nombre de colonnes dans le jeu de résultats
    * @return: (Int) le nombre total trouvé
    */
    public function columnCount()
    {
    	self::tableExiste();
		$bdd = self::connexion_base();
		$pdo_stmt = $bdd->query("SELECT * FROM $this->table");
		$total = $pdo_stmt->columnCount();
		return $total;
    }


    /**
    * Retourne le nombre de lignes affectées par le dernier appel à la fonction
    * @param: $row (le nom de la colonne ou chercher)
    * @param: $data (le contenu a chercher)
    * @return: (Int) le nombre total trouvé
    */
    public function rowCount($row = "", $data = "")
    {
    	$row = htmlentities($row, ENT_QUOTES); // anti injection SQL
    	$data = htmlentities($data, ENT_QUOTES); // anti injection SQL
    	self::tableExiste();
		$bdd = self::connexion_base();
		if (!empty($row) && !empty($data)) {
			$pdo_stmt = $bdd->query("SELECT * FROM $this->table WHERE $row = '$data' ");
		} else {
			$pdo_stmt = $bdd->query("SELECT * FROM $this->table");
		}
		$total = $pdo_stmt->rowCount();
		return $total;
    }


    /**
    * Retourne les métadonnées pour une colonne d'un jeu de résultats
    * @param: $i (numéro de la colonne)
    */
    public function getColumnMeta($i)
    {
    	if (!is_numeric($i)){
			return false;
		}
    	self::tableExiste();
		$bdd = self::connexion_base();
		$pdo_stmt = $bdd->query("SELECT * FROM $this->table");
		$total = $pdo_stmt->getColumnMeta($i);
		return $total;
    }


    /**
    * Retourne la clé primaire de la table
    * @return: (string) le nom de la PRIMARY_KEY
    */
    public function primaryKey()
    {
    	self::tableExiste();
		$bdd = self::connexion_base();
		$pdo_stmt = $bdd->query("SELECT * FROM $this->table");
		$meta = "";
		for($i=0; $i < $pdo_stmt->columnCount(); $i++)
		{
			if (in_array("primary_key", $pdo_stmt->getColumnMeta($i)['flags'])) 
			{
				$meta .= $pdo_stmt->getColumnMeta($i)['name'];
			}
		}
		return $meta;
    }


    /**
	 * Retourne l'identifiant de la dernière ligne insérée
	 * @return: int L'id
	 */
	public function lastInsertId()
	{
		return self::connexion_base()->lastInsertId();
	}


	/**
	* Affiche un $array d'un find($id) ou d'un findAll() dans un <table> html
	* @param $array (récupérer d'un find($id) ou d'un findAll())
	* @return Affiche l'array dans un tableau html
	*/
	public function stylish($arrayFromSelect)
	{
		echo '<table style="margin: 10px 0;" border="1">';
		$doublon = [];
		echo '<tr>';
		foreach ($arrayFromSelect as $tab) 
		{
			// Table Head <th></th>
			foreach ($tab as $key => $info) 
			{
				// On verifie les clés en double pour le th
				if (!in_array($key, $doublon)) {
					echo '<th style="text-align:left; padding:5px;">' . $key . '</th>';
					array_push($doublon, $key);	
				}
			}
		}
		echo '</tr>';
		foreach ($arrayFromSelect as $tab) 
		{
			// Table Data <td></td>
			echo '<tr>';
			foreach ($tab as $info) 
			{
				echo '<td style="padding:5px;">' . $info . '</td>';
			}
			echo '</tr>';
		}
		echo '</table>';
	}


}