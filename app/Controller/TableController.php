<?php

namespace app\Controller {

    use Silex\Application;
    use Silex\ControllerProviderInterface;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use app\classes\KineConstant;
    use app\classes\KineException;

    class TableController implements ControllerProviderInterface {

        public function connect(Application $app) {

            $tableController = $app['controllers_factory'];
            $tableController->get("/{id}/params", array($this, "paramsAction"));
            $tableController->put("/{id}/params/{pid}", array($this, "pidParamsAction"));

            return $tableController;
        }

        public function paramsAction(Application $app, $id) {

            $sql = "SELECT *
            FROM kine_param 
            WHERE kine_param.kine_table_id = ".$id;

            $results = $app['db']->fetchAll($sql);

            $entity = new \stdClass();
            $entity->id = (int) $results[0]['id'];
            $entity->tableId = (int) $results[0]['kine_table_id'];
            $entity->name = (string) $results[0]['name'];
            $entity->showImage = (boolean) $results[0]['show_image'];
            $entity->showColor = (boolean) $results[0]['show_color'];
            $entity->showWord = (boolean) $results[0]['show_word'];
            $entity->showSentence = (boolean) $results[0]['show_sentence'];
            $entity->showPhonem = (boolean) $results[0]['show_phonem'];
            $entity->showPhonemSound = (boolean) $results[0]['show_phonem_sound'];
            $entity->showWordSound = (boolean) $results[0]['show_word_sound'];
            $entity->showSentenceSound = (boolean) $results[0]['show_sentence_sound'];

            $data = json_encode($entity, JSON_PRETTY_PRINT);
            return new Response($data, 200, array('ContentType' => 'application/json'));
        }

        public function pidParamsAction(Application $app, Request $request) {
            
            try {
                
                $payload = json_decode($request->getContent());
                
                // check if params exists
                $sql = "SELECT *
                    FROM kine_param 
                    WHERE kine_param.kine_table_id = {$payload->id}";

                $results = $app['db']->fetchAll($sql);
                if (!$results) {
                    throw new Exception('Error', 400);
                }

                $param = new \stdClass();
                $param->id = $payload->id;
                $param->tableId = $payload->tableId;
                $param->showColor = $payload->showColor ? 1 : 0;
                $param->showImage = $payload->showImage ? 1 : 0;
                $param->showWord = $payload->showWord ? 1 : 0;
                $param->showPhonem = $payload->showPhonem ? 1 : 0;
                $param->showSentence = $payload->showSentence ? 1 : 0;

                $param->showWordSound = $payload->showWordSound ? 1 : 0;
                $param->showPhonemSound = $payload->showPhonemSound ? 1 : 0;
                $param->showSentenceSound = $payload->showSentenceSound ? 1 : 0;

                $sql = "    UPDATE kine_param "
                        . " SET show_color=" . $param->showColor . ", "
                        . "     show_image=" . $param->showImage . ","
                        . "     show_word=" . $param->showWord . ","
                        . "     show_phonem=" . $param->showPhonem . ","
                        . "     show_sentence=" . $param->showSentence . ","
                        . "     show_word_sound=" . $param->showWordSound . ","
                        . "     show_phonem_sound=" . $param->showPhonemSound . ","
                        . "     show_sentence_sound=" . $param->showSentenceSound . ""
                        . " WHERE id=" . $param->id;

                $app['db']->executeUpdate($sql);

                return new Response(json_encode($param), 200, array('ContentType' => 'application/json'));
            } catch (Exception $ex) {
                $app['monolog']->addError("EXCEPTION :: " . $ex->getMessage() . " " . $ex->getTrace());
                return new Response("Error", 400);
            }
        }
        
    }

}
