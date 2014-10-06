<?php

/**
 * Description of KineException
 *
 * @author innova
 */
class KineException extends Exception {

    /**
     * 
     */
    const KEXCEPTION_NO_TABLE_PARAM_MESSAGE = "No table id defined in url.";
    const KEXCEPTION_NO_TABLE_PARAM_CODE = 0;

    /**
     * 
     */
    const KEXCEPTION_NO_LANGUAGE_MESSAGE = "No language or associated table found for language id [%u] and table id [%u].";
    const KEXCEPTION_NO_LANGUAGE_CODE = 1;

    /**
     * 
     */
    const KEXCEPTION_NO_ITEMS_MESSAGE = "No items found for language with id [%u] and table with id [%u].";
    const KEXCEPTION_NO_ITEMS_CODE = 2;

    /**
     * 
     */
    const KEXCEPTION_NO_SOUNDS_MESSAGE = 'No sounds found for language with id [%u] and table with id [%u].';
    const KEXCEPTION_NO_SOUNDS_CODE = 3;

    /**
     * 
     */
    const KEXCEPTION_NO_IMAGES_MESSAGE = 'No images found for language with id [%u] and table with id [%u].';
    const KEXCEPTION_NO_IMAGES_CODE = 4;
    
    /**
     * 
     */
    const KEXCEPTION_NO_TEXTS_MESSAGE = 'No texts found for language with id [%u] and table with id [%u].';
    const KEXCEPTION_NO_TEXTS_CODE = 5;

    /**
     * 
     */
    const KEXCEPTION_NO_PARAMS_MESSAGE = 'No params found for language with id [%u] and table with id [%u].';
    const KEXCEPTION_NO_PARAMS_CODE = 5;

}
