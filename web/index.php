<?php
require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$app = new Silex\Application();
$app['debug'] = true;

$pdo = new PDO('mysql:host=localhost;dbname=kinephone', "kinephone", "kinephone$");

// default parameters
$defaults = array(
    'limit'  => '10',
    'offset' => '0'
);

// result
$output = '';

// GET ITEMS
$app->get('/items', function (Request $request) use ($pdo, $defaults) {

    try {
        $statement = $pdo->prepare('SELECT * FROM item LIMIT :limit OFFSET :offset');
        $statement->bindValue(':limit', (int)$defaults['limit'], PDO::PARAM_INT);

        if ($request->query->get('offset')) {
            $statement->bindValue(':offset', (int)$request->query->get('offset'), PDO::PARAM_INT);
        }
        else {
            $statement->bindValue(':offset', (int)$defaults['offset'], PDO::PARAM_INT);
        }

        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        $output = json_encode($results, JSON_PRETTY_PRINT);
        $pdo = null;
    } catch (PDOException $e) {
        $output = "Erreur !: " . $e->getMessage();
    }
    return $output;
});

// GET ITEM BY ID
$app->get('/items/{id}', function (Silex\Application $app, $id) use ($pdo, $defaults) {

    try {
        $statement = $pdo->prepare("SELECT * FROM item where id = {$id}");
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        $output = json_encode($results, JSON_PRETTY_PRINT);
        $pdo = null;
    } catch (PDOException $e) {
        $output = "Erreur !: " . $e->getMessage();
    }

    return $output;
});


// GET IMAGES
$app->get('/images', function (Request $request) use ($pdo, $defaults) {

    try {
        $statement = $pdo->prepare("SELECT * FROM image LIMIT :limit OFFSET :offset");
        $statement->bindValue(':limit', (int)$defaults['limit'], PDO::PARAM_INT);

        if ($request->query->get('offset')) {
            $statement->bindValue(':offset', (int)$request->query->get('offset'), PDO::PARAM_INT);
        }
        else {
            $statement->bindValue(':offset', (int)$defaults['offset'], PDO::PARAM_INT);
        }

        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        $output = json_encode($results, JSON_PRETTY_PRINT);
        $pdo = null;
    } catch (PDOException $e) {
        $output = "Erreur !: " . $e->getMessage();
    }

    return $output;
});
// GET IMAGE BY ID
$app->get('/images/{id}', function (Silex\Application $app, $id) use ($pdo, $defaults) {

    try {
        $statement = $pdo->prepare("SELECT * FROM image where id = {$id}");
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        $output = json_encode($results, JSON_PRETTY_PRINT);
        $pdo = null;
    } catch (PDOException $e) {
        $output = "Erreur !: " . $e->getMessage();
    }

    return $output;
});


// LANGUAGES
$app->get('/languages', function (Request $request) use ($pdo, $defaults) {

    try {
        $statement = $pdo->prepare("SELECT * FROM language LIMIT :limit OFFSET :offset");
        $statement->bindValue(':limit', (int)$defaults['limit'], PDO::PARAM_INT);

        if ($request->query->get('offset')) {
            $statement->bindValue(':offset', (int)$request->query->get('offset'), PDO::PARAM_INT);
        }
        else {
            $statement->bindValue(':offset', (int)$defaults['offset'], PDO::PARAM_INT);
        }

        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        $output = json_encode($results, JSON_PRETTY_PRINT);
        $pdo = null;
    } catch (PDOException $e) {
        $output = "Erreur !: " . $e->getMessage();
    }

    return $output;
});

// LANGUAGE BY ID
$app->get('/languages/{id}', function (Silex\Application $app, $id) use ($pdo, $defaults) {

    try {
        $statement = $pdo->prepare("SELECT * FROM language where id = {$id}");
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        $output = json_encode($results, JSON_PRETTY_PRINT);
        $pdo = null;
    } catch (PDOException $e) {
        $output = "Erreur !: " . $e->getMessage();
    }

    return $output;
});

// SOUNDS
$app->get('/sounds', function (Request $request) use ($pdo, $defaults) {

    try {
        $statement = $pdo->prepare("SELECT * FROM sound LIMIT :limit OFFSET :offset");
        $statement->bindValue(':limit', (int)$defaults['limit'], PDO::PARAM_INT);

        if ($request->query->get('offset')) {
            $statement->bindValue(':offset', (int)$request->query->get('offset'), PDO::PARAM_INT);
        }
        else {
            $statement->bindValue(':offset', (int)$defaults['offset'], PDO::PARAM_INT);
        }

        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        $output = json_encode($results, JSON_PRETTY_PRINT);
        $pdo = null;
    } catch (PDOException $e) {
        $output = "Erreur !: " . $e->getMessage();
    }

    return $output;
});
// SOUND BY ID
$app->get('/sounds/{id}', function (Silex\Application $app, $id) use ($pdo, $defaults) {

    try {
        $statement = $pdo->prepare("SELECT * FROM sound where id = {$id}");
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        $output = json_encode($results, JSON_PRETTY_PRINT);
        $pdo = null;

    } catch (PDOException $e) {
        $output = "Erreur !: " . $e->getMessage();
    }

    return $output;
});

// TEXTS
$app->get('/texts', function (Request $request) use ($pdo, $defaults) {

    try {
        $statement = $pdo->prepare("SELECT * FROM text LIMIT :limit OFFSET :offset");
        $statement->bindValue(':limit', (int)$defaults['limit'], PDO::PARAM_INT);

        if ($request->query->get('offset')) {
            $statement->bindValue(':offset', (int)$request->query->get('offset'), PDO::PARAM_INT);
        }
        else {
            $statement->bindValue(':offset', (int)$defaults['offset'], PDO::PARAM_INT);
        }

        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        $output = json_encode($results, JSON_PRETTY_PRINT);
        $pdo = null;
    } catch (PDOException $e) {
        $output = "Erreur !: " . $e->getMessage();
    }

    return $output;
});

// TEXT BY ID
$app->get('/texts/{id}', function (Silex\Application $app, $id) use ($pdo, $defaults) {

    try {
        $statement = $pdo->prepare("SELECT * FROM text where id = {$id}");
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        $output = json_encode($results, JSON_PRETTY_PRINT);
        $pdo = null;
    } catch (PDOException $e) {
        $output = "Erreur !: " . $e->getMessage();
    }

    return $output;
});

// METHODS
$app->get('/methods', function (Request $request) use ($pdo, $defaults) {

    try {
        $statement = $pdo->prepare("SELECT * FROM method LIMIT :limit OFFSET :offset");
        $statement->bindValue(':limit', (int)$defaults['limit'], PDO::PARAM_INT);

        if ($request->query->get('offset')) {
            $statement->bindValue(':offset', (int)$request->query->get('offset'), PDO::PARAM_INT);
        }
        else {
            $statement->bindValue(':offset', (int)$defaults['offset'], PDO::PARAM_INT);
        }

        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        $output = json_encode($results, JSON_PRETTY_PRINT);
        $pdo = null;
    } catch (PDOException $e) {
        $output = "Erreur !: " . $e->getMessage();
    }

    return $output;
});

// METHOD BY ID
$app->get('/methods/{id}', function (Silex\Application $app, $id) use ($pdo, $defaults) {

    try {
        $statement = $pdo->prepare("SELECT * FROM method where id = {$id}");
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        $output = json_encode($results, JSON_PRETTY_PRINT);
        $pdo = null;
    } catch (PDOException $e) {
        $output = "Erreur !: " . $e->getMessage();
    }

    return $output;
});


// ENTITY BY LANGUAGE AND METHOD IDs
$app->get('/kinephones/{lId}', function (Request $request, $lId) use ($pdo, $defaults) {

    $entity = new stdClass();

    try {
	
        $sql = "	SELECT l.*, m.id AS id_method, m.name, m.image_url 
					FROM language l
					JOIN method m ON m.language_id = l.id 
					WHERE l.id = {$lId} AND m.id = :method 
					LIMIT :limit OFFSET :offset";

        $statement = $pdo->prepare($sql);
        
        // method id param
        if ($request->query->get('method')) {
            $statement->bindValue(':method', (int)$request->query->get('method'), PDO::PARAM_INT);
        }
        else{
			return 'No method id defined in url';
		}
        
        // limits & offset params
        $limit = (int)$defaults['limit'];
        if ($request->query->get('limit')) {
            $limit = (int)$request->query->get('limit');
        }
        
        $offset = (int)$defaults['offset'];
        if ($request->query->get('offset')) {
            $offset = (int)$request->query->get('offset');
        }
        
		$statement->bindValue(':limit', $limit, PDO::PARAM_INT);
		$statement->bindValue(':offset', $offset, PDO::PARAM_INT);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        // entity main data
        $entity->language_id = (int) $results[0]['id'];
        $entity->code_iso = (string) $results[0]['code_iso_639'];
        $entity->code_unicode = (string) $results[0]['code_unicode_api'];
        $entity->method_id = (int) $results[0]['id_method'];
        $entity->name = (string) $results[0]['name'];
        $entity->image = (string) $results[0]['image_url'];

        // items related to entity
        $entity->items = array();

        $sql = "SELECT * FROM item where method_id = {$entity->method_id}";
        $statement = $pdo->prepare($sql);
        $statement->execute();
        $items = $statement->fetchAll(PDO::FETCH_ASSOC);       

        // populate each item with his images / sounds / texts
        foreach ($items as $item){
			
            // item id and coords
            $itemId = (int) $item['id'];
            $itemCoords = (string) $item['coords'];            
            
             // sounds for each item
			$itemSounds = new stdClass();
			$itemSounds->sounds = array();

			// images for each item
			$itemImages = new stdClass();
			$itemImages->images = array();

			// texts for each item
			$itemTexts = new stdClass();
			$itemTexts->texts = array();
			
			// sounds query
            $sql = "SELECT * FROM sound where item_id = {$itemId}";
            $statement = $pdo->prepare($sql);
            $statement->execute();
            $sounds = $statement->fetchAll(PDO::FETCH_ASSOC);

            // create item sounds array
            foreach ($sounds as $sound){
                $itemSounds->sounds[] = array(
					'id'		=> (int) $sound['id'],
					'type'		=> (string) $sound['sound_type'],
					'url'		=> (string) $sound['url'],
					'gender'	=> (string) $sound['gender'],
					'visible'	=> (boolean) $sound['visible']
				);
            }

			// images query
            $sql = "SELECT * FROM image where item_id = {$itemId}";
            $statement = $pdo->prepare($sql);
            $statement->execute();
            $images = $statement->fetchAll(PDO::FETCH_ASSOC);

            // create item images array
            foreach ($images as $image){
                $itemImages->images[] = array(
					'id'			=> (int) $image['id'],
					'image_type' 	=> (string) $image['image_type'],
					'url' 			=> (string) $image['url'],
					'visible' 		=> (boolean) $image['visible']
				);
            }

            // texts query
            $sql = "SELECT * FROM text where item_id = {$itemId}";
            $statement = $pdo->prepare($sql);
            $statement->execute();
            $texts = $statement->fetchAll(PDO::FETCH_ASSOC);

            // create item texts array
            foreach ($texts as $text){
				$itemTexts->texts[] = array(
					'id'		=> (int) $text['id'],
					'text_type'	=> (string) $text['text_type'],
					'text'		=> (string) $text['text'],
					'visible'	=> (boolean) $text['visible']
				);
            }
            $entity->items[] = array(
                'id'     => $itemId,
                'coords' => $itemCoords,
                'sounds' => $itemSounds -> sounds,
                'images' => $itemImages -> images,
                'texts'  => $itemTexts -> texts
            );

             
        }
		$output = json_encode($entity, JSON_PRETTY_PRINT);     
        $pdo = null;    
		
    } catch (PDOException $e) {
        return "Erreur !: " . $e->getMessage();        
    }
    return $output;
});

$app->run();
