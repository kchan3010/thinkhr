<?php
/**
 * Parser.php
 *
 * @company StitchLabs
 * @project thinkHr
 *
 * @author  kennychan
 */
use Interfaces\Validator;

/**
 * Class Parser
 */

namespace Classes;

use Exception;
use Interfaces\Transformer;
use Interfaces\DataValidator;

class PersonalIdentifier
{

    protected $parser;
    protected $validator;
    protected $entries;
    protected $errors = [];
    protected $line_counter = 1;
    protected $transformer;

    public function __construct(DataValidator $validator, Transformer $transformer)
    {
        $this->setValidator($validator);
        $this->setTransformer($transformer);
    }

    public function process($entry_data)
    {
        if (count($entry_data) < EntryDataTransformer::FULL_NAME_PARTS_COUNT) {
            $this->errors[] = $this->line_counter;
            $this->line_counter++;
            return "";
        }

        $parsed_data = $this->parse($entry_data);
    
        $person = new Person($parsed_data);
        $this->entries[] = $person->jsonSerialize();
    
        $this->line_counter++;
        return "";
    }

    public function getResults()
    {
        $results = [
            'entries' => $this->getEntries(),
            'errors'  => $this->getErrors(),
        ];
        
        
        $json =  json_encode($results);
        
        return EntryDataTransformer::jsonPrint($json);
    }

    /**
     * @param mixed $validator
     * @return PersonalIdentifier
     */
    public function setValidator($validator)
    {
        $this->validator = $validator;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValidator()
    {
        return $this->validator;
    }

    /**
     *
     */
    private function parse($entry_data)
    {
        $transformed_data = $this->getTransformer()->transform($entry_data);
        
        if (!$this->getValidator()->isValidPhone($transformed_data['phone'])) {
            $this->errors[] = $this->line_counter;
            return false;
        }
        
        return $transformed_data;
    }
    
    /**
     * @return mixed
     */
    public function getEntries()
    {
        return $this->entries;
    }
    
    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }
    
    /**
     * @param mixed $transformer
     *
     * @return PersonalIdentifier
     */
    public function setTransformer($transformer)
    {
        $this->transformer = $transformer;
        
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getTransformer()
    {
        return $this->transformer;
    }
    
    
}