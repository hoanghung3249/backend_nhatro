<?php
namespace definititions;
/**
 * @SWG\Definition(required={"name", "photoUrls"}, type="object", @SWG\Xml(name="Pet"))
 */
class Register
{

    /**
     * @SWG\Property(example="hoanghung@gmail.com")
     * @var string
     */
    public $email;
    /**
     * @SWG\Property(example="Hung")
     * @var string
     */
    public $first_name;
    /**
     * @SWG\Property(example="Nguyen")
     * @var string
     */
    public $last_name;
    /**
     * @SWG\Property(example="0937094414")
     * @var string
     */
    public $phone;
    /**
     * @SWG\Property(example="123456")
     * @var string
     */
    public $password;
}