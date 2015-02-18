<?php

namespace app\Controller {

    use Silex\Application;
    use Silex\ControllerProviderInterface;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use app\classes\KineConstant;
    use app\classes\KineException;

    class LanguageController implements ControllerProviderInterface {

        public function connect(Application $app) {

            $languageController = $app['controllers_factory'];
            $languageController->get("/", array($this, "languageAction"));
            $languageController->get("/{lid}/tables", array($this, "tablesAction"));
            $languageController->get("/{lid}/table/{tid}/items", array($this, "itemsAction"));

            return $languageController;
        }

        public function languageAction(Application $app) {

            try {
                $sql = "SELECT l.id AS language_id, l.name AS language_name, l.code_iso AS language_code_iso
                            FROM kine_language l";

                $results = $app['db']->fetchAll($sql);

                $languages = array();

                foreach ($results as $r) {
                    $o = new \stdClass();
                    $o->language_id = (int) $r['language_id'];
                    $o->language_name = utf8_encode($r['language_name']);
                    $o->language_code_iso = utf8_encode($r['language_code_iso']);
                    $languages[] = $o;
                }

                $data = json_encode($languages, JSON_PRETTY_PRINT);
                return new Response($data, 200, array('ContentType' => 'application/json'));
            } catch (Exception $ex) {
                $app['monolog']->addError("EXCEPTION :: " . $ex->getMessage() . " " . $ex->getTrace());
                return new Response("Error", 400);
            }
        }

        public function tablesAction(Application $app, $lid) {

            try {
                $sql = "SELECT t.id AS table_id, t.name AS table_name, t.image_url
                        FROM kine_table t 
                        WHERE t.kine_language_id = ".$lid;

                $results = $app['db']->fetchAll($sql);

                $tables = array();

                foreach ($results as $r) {
                    $o = new \stdClass();
                    $o->table_id = (int) $r['table_id'];
                    $o->table_name = utf8_encode($r['table_name']);
                    $o->image_url = $r['image_url'];
                    $tables[] = $o;
                }

                $response = json_encode($tables, JSON_PRETTY_PRINT);

                return new Response($response, 200, array('ContentType' => 'application/json'));
            } catch (Exception $ex) {
                $app['monolog']->addError("EXCEPTION :: " . $ex->getMessage() . " " . $ex->getTrace());
                return new Response("Error", 400);
            }
        }

        public function itemsAction(Application $app, $lid, $tid) {

            // default parameters
            $defaults = array(
                'limit' => '10',
                'offset' => '0'
            );

            $entity = new \stdClass();

            try {

                $sql = " SELECT l.*, t.id AS id_table, t.name, t.image_url
                        FROM kine_language l
                        JOIN kine_table t ON t.kine_language_id = l.id
                        WHERE l.code_iso = '" . $lid . "' AND t.id = " . $tid . "
                        LIMIT ".$defaults['limit']." OFFSET ".$defaults['offset'];

                $results = $app['db']->fetchAll($sql);

                if (!$results) {
                    throw new KineException(
                    sprintf(KineException::KEXCEPTION_NO_LANGUAGE_MESSAGE, $lid, $mid), KineException::KEXCEPTION_NO_LANGUAGE_CODE
                    );
                }
                
                // entity main data
                $entity->language_id = (int) $results[0]['id'];
                $entity->code_iso = (string) $results[0]['code_iso'];
                $entity->table_id = (int) $results[0]['id_table'];
                $entity->name = (string) utf8_encode($results[0]['name']);
                $entity->image = (string) $results[0]['image_url'];

                // items related to entity
                $entity->items = array();

                $sql = "SELECT ki.id, kti.coords FROM kine_item ki JOIN kine_table_item kti ON kti.kine_item_id = ki.id where kti.kine_table_id = {$tid}";
                $items = $app['db']->fetchAll($sql);

                if (!$items) {
                    throw new KineException(
                    sprintf(KineException::KEXCEPTION_NO_ITEMS_MESSAGE, $lid, $mid), KineException::KEXCEPTION_NO_ITEMS_CODE
                    );
                }

                // get params for the selected table
                // params are used only to change queries as necessary
                $sql = " SELECT p.* 
                FROM kine_param p
                WHERE p.kine_table_id = {$entity->table_id}";

                $params = $app['db']->fetchAll($sql);

                if (!$params) {
                    throw new KineException(
                    sprintf(KineException::KEXCEPTION_NO_PARAMS_MESSAGE, $lid, $mid), KineException::KEXCEPTION_NO_PARAMS_CODE
                    );
                }

                $showImage = (boolean) $params[0]['show_image'];
                $showColor = (boolean) $params[0]['show_color'];
                $showWord = (boolean) $params[0]['show_word'];
                $showSentence = (boolean) $params[0]['show_sentence'];
                $showPhonem = (boolean) $params[0]['show_phonem'];
                $showPhonemSound = (boolean) $params[0]['show_phonem_sound'];
                $showWordSound = (boolean) $params[0]['show_word_sound'];
                $showSentenceSound = (boolean) $params[0]['show_sentence_sound'];

                // populate each item with his images / sounds / texts
                foreach ($items as $item) {

                    // item id and coords
                    $itemId = (int) $item['id'];
                    $itemCoords = (string) $item['coords'];

                    // sounds for each item
                    $itemSounds = new \stdClass();
                    $itemSounds->sounds = array();

                    // images for each item
                    $itemImages = new \stdClass();
                    $itemImages->images = array();

                    // texts for each item
                    $itemTexts = new \stdClass();
                    $itemTexts->texts = array();

                    if ($showPhonemSound || $showSentenceSound || $showWordSound) {
                        // sounds query
                        $sql = "SELECT * FROM kine_sound WHERE kine_item_id = {$itemId} AND sound_type = ( 'all' ";
                        if ($showPhonemSound) {
                            $sql .= " OR '" . KineConstant::SOUND_TYPE_PHONEM . "'";
                        }
                        if ($showSentenceSound) {
                            $sql .= " OR '" . KineConstant::SOUND_TYPE_SENTENCE . "'";
                        }
                        if ($showSentenceSound) {
                            $sql .= " OR '" . KineConstant::SOUND_TYPE_WORD . "'";
                        }

                        $sql .= " )";

                        $sounds = $app['db']->fetchAll($sql);

                        if (!$sounds) {
                            throw new KineException(
                            sprintf(KineException::KEXCEPTION_NO_SOUNDS_MESSAGE, $lid, $mid), KineException::KEXCEPTION_NO_SOUNDS_CODE
                            );
                        }

                        // create item sounds array
                        foreach ($sounds as $sound) {
                            $itemSounds->sounds[] = array(
                                'id' => (int) $sound['id'],
                                'type' => (string) $sound['sound_type'],
                                'url' => (string) $sound['url'],
                                'gender' => (string) $sound['gender']
                            );
                        }
                    }

                    if ($showColor || $showImage) {
                        // images query
                        $sql = "SELECT * FROM kine_image WHERE kine_item_id = {$itemId} AND image_type = ( 'all' ";
                        if ($showColor) {
                            $sql .= " OR '" . KineConstant::IMAGE_TYPE_COLOR . "'";
                        }
                        if ($showImage) {
                            $sql .= " OR '" . KineConstant::IMAGE_TYPE_DRAWING . "'";
                        }
                        $sql .= " )";

                        $images = $app['db']->fetchAll($sql);

                        if (!$images) {
                            throw new KineException(
                            sprintf(KineException::KEXCEPTION_NO_IMAGES_MESSAGE, $lid, $mid), KineException::KEXCEPTION_NO_IMAGES_CODE
                            );
                        }

                        // create item images array
                        foreach ($images as $image) {
                            $itemImages->images[] = array(
                                'id' => (int) $image['id'],
                                'image_type' => (string) $image['image_type'],
                                'url' => (string) $image['url']
                            );
                        }
                    }

                    if ($showWord || $showSentence || $showPhonem) {
                        // texts query
                        $sql = "SELECT * FROM kine_text where kine_item_id = {$itemId} AND text_type = ( 'all' ";
                        if ($showWord) {
                            $sql .= " OR '" . KineConstant::TEXT_TYPE_WORD . "'";
                        }
                        if ($showSentence) {
                            $sql .= " OR '" . KineConstant::TEXT_TYPE_SENTENCE . "'";
                        }
                        if ($showPhonem) {
                            $sql .= " OR '" . KineConstant::TEXT_TYPE_PHONETIC . "'";
                        }
                        $sql .= " )";

                        $texts = $app['db']->fetchAll($sql);

                        if (!$texts) {
                            throw new KineException(
                            sprintf(KineException::KEXCEPTION_NO_TEXTS_MESSAGE, $lid, $mid), KineException::KEXCEPTION_NO_TEXTS_CODE
                            );
                        }

                        // create item texts array
                        foreach ($texts as $text) {
                            $itemTexts->texts[] = array(
                                'id' => (int) $text['id'],
                                'text_type' => (string) $text['text_type'],
                                'text' => $text['text']
                            );
                        }
                    }

                    $entity->items[] = array(
                        'id' => $itemId,
                        'coords' => $itemCoords,
                        'sounds' => $itemSounds->sounds,
                        'images' => $itemImages->images,
                        'texts' => $itemTexts->texts
                    );
                }
                $data = json_encode($entity, JSON_PRETTY_PRINT);
                return new Response($data, 200, array('ContentType' => 'application/json'));
            } catch (PDOException $pdoe) {
                $app['monolog']->addError("PDO ERROR :: " . $pdoe->getMessage() . " " . $pdoe->getTrace());
                return new Response(null, 400);
            } catch (KineException $ke) {
                $app['monolog']->addError("KINEPHONE ERROR :: " . $ke->getMessage() . " WITH CODE :: " . $ke->getCode());
                return new Response(null, 404);
            } catch (Exception $e) {
                echo $e . getMessage();
                die;
            }
        }

    }

}
