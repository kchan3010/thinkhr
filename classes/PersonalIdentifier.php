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
use Interfaces\Validator;

class PersonalIdentifier
{

    protected $parser;
    protected $validator;
    protected $entries;
    protected $errors = [];
    protected $line_counter = 1;

    public function __construct(Validator $validator)
    {
        $this->setValidator($validator);
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
        $transformed_data = EntryDataTransformer::transform($entry_data);
        
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
    
    
}