<?php
namespace definititions;
/**
 * @SWG\Definition(required={"name", "photoUrls"}, type="object", @SWG\Xml(name="Pet"))
 */
class Newpassword
{

    /**
     * @SWG\Property(example="")
     * @var integer
     */
    public $id;

    /**
     * @SWG\Property(example="")
     * @var string
     */
    public $password;
    /**
     * @SWG\Property(example="")
     * @var string
     */
    public $token;

}