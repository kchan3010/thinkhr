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
        if (empty($entry_data)) {
            throw new Exception("There are no data to process");
        }

        $this->parse($entry_data);

        $this->line_counter++;
        return "";
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
        
        if (!$this->getValidator()->isValidatePhone($transformed_data['phone'])) {
            $this->errors[] = $this->line_counter;
            return;
        }
        
        $person = new Person();



    }






}