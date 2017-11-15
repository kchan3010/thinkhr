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
    
    /**
     * @param $entry_data
     *
     * @return bool
     */
    public function process($entry_data)
    {
        if (count($entry_data) < EntryDataTransformer::FULL_NAME_PARTS_COUNT) {
            $this->errors[] = $this->line_counter;
            $this->line_counter++;
            return false;
        }
        
        $parsed_data = $this->parse($entry_data);
    
        if(empty($parsed_data)) {
            return false;
        }
        
        $person = new Person($parsed_data);
        $this->entries[] = $person->jsonSerialize();
    
        $this->line_counter++;
        
        return true;
    }
    
    /**
     * @param string $filename
     */
    public function getResults($filename='output.txt')
    {
        $results = [
            'entries' => $this->getEntries(),
            'errors'  => $this->getErrors(),
        ];
        
        $data = $this->getTransformer()->prepareJson($results);
        
        if (empty($data)) {
            $data = "Error in preparing JSON";
        }
        
        file_put_contents($filename, $data);
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
    
    /**
     * @param $entry_data
     *
     * @return array
     */
    private function parse($entry_data)
    {
        $transformed_data = $this->getTransformer()->transform($entry_data);
        
        if (!$this->getValidator()->isValidPhone($transformed_data['phone'])) {
            $this->errors[]   = $this->line_counter;
            $transformed_data = [];
        }
        
        return $transformed_data;
    }
    
    
}