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

    const FULL_NAME_PARTS_COUNT = 4;
    const SPLIT_NAME_PARTS_COUNT = 5;

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
        if (count($entry_data) == self::FULL_NAME_PARTS_COUNT) {
            if (!$this->getValidator()->isValidatePhone($entry_data[4])) {
                $this->errors[] = $this->line_counter;
                return;
            }

            $phone = PhoneTransformer::transform($entry_data[4]);
            list($first_name, $last_name) = explode(" ", $entry_data[0]);
            $color = $entry_data[1];
            $zipcode = $entry_data[2];

        }
    }






}