<?php
namespace definititions;
/**
 * @SWG\Definition(required={"name", "photoUrls"}, type="object", @SWG\Xml(name="Pet"))
 */
class Forgotpassword
{

    /**
     * @SWG\Property(example="")
     * @var string
     */
    public $email;
}