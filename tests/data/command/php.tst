    $myObj = getMyObj();
    $a = get_class($myObj);
    $arr = '123';
    echo count($arr);
    return array_unique ([1, 2, 2, 3])[0];
    is_object ($myObj);
    if (number_format(-0.01, 0) === '-0') {
        return 123;
    }
    $resource = open('resource_path');
    close($resource);
    return (gettype($resource) === 'unknown_type') ? true : false;
    bcmod('4', '3.5');
    hash_hmac_file('crc32', 'my_data');
    return mt_rand (12432523);
    $string = <<<MYSTR
        MYSTR - error!
MYSTR;
    preg_replace('/123/', '11', '1234567');
    switch ($a) {
        case 123:
            echo 123;
            continue;
        case 256:
            echo 256;
            break;
        default:
            echo 'error';
    }
    $result = date_parse_from_format('dd.mm.yyyy hh:nn:ssTZ');
    echo $result['zone'];
    throw new JsonException();
    const JSON_THROW_ON_ERROR = 35;
    __autoload('vendor/autoload.php');
    return png2wbmp('my_image.png');
    return jpeg2wbmp('my_image.jpg');
    return image2wbmp('my_image.bmp');
    MyClass::$value = &$myVal;
    $myVal = 1;
    $size = getimagesize('my_image.bmp');
    return $size['mime'] === 'image/x-ms-bmp';
    mb_ereg('(?<word>\w+)', '国', $matches);
    strpos($a, $b, $c);
    strrpos($a, $b, $c);
    stripos($a, $b, $c);
    strripos($a, $b, $c);
    strstr($a, $b, $c);
    strchr($a, $b, $c);
    strrchr($a, $b, $c);
    stristr($a, $b, $c);
    (unset)$myvar;
    parse_str($a);
    gmp_random(1, 3);
    each($arr as $key => $value) {
        assert('$i = 3');
    }
    filter_var ($t, FILTER_FLAG_SCHEME_REQUIRED, FILTER_FLAG_HOST_REQUIRED);
    define('GREETING', 'Hello you.', true);
    public static function assert (string $eval) {
        return eval($eval);
    };
    fgetss('AAA<b>BBB</b>');
    gzgetss('AAA<b>BBB</b>');
    stream_filter_append($fp, 'string.strip_tags');
    mbregex_encoding($a, $b, $c)
    mbereg($a, $b, $c)
    mbsplit($a, $b, $c)
    var_dump($php_errormsg);
    $myfunc = create_function  ();
    print_r($errcontext);
    json_last_error_msg();
    echo INTL_IDNA_VARIANT_2003;
    read_exif_data();
    define('GREET', 'Hello you.', false);
    define('GREETS', 'Hello you.');
    strpos('a', 'b', $c);
    strrpos('a', 'b', $c);
    stripos('a', 'b', $c);
    strripos(a', 'b', $c);
    strstr('a','b', $c);
    strchr('a',       'b', $c);
    strrchr('a', 'b', $c);
    stristr('a', 'b', $c);
    public function          setUp     (        ): void
    {
    }
    public function    setUpBeforeClass(        )         : void
    {
    }
    public function     tearDown(   )                 :       void
    {
    }
    public function tearDownAfterClass(   )   :void
    {
    }
    public function assertPreConditions()    :void
    {
    }
    public function assertPostConditions(): void
    {
    }
    public function onNotSuccessfulTest(   ) : void
    {
    }
    public function          setUp     (        )
    {
    }
    public function    setUpBeforeClass(        )
    {
    }
    public function     tearDown(   )                        void
    {
    }
    public function tearDownAfterClass(   )
    {
    }
    public function assertPreConditions()    id
    {
    }
    public function assertPostConditions()
    {
    }
    public function onNotSuccessfulTest(   )
    {
    }
    $this->assertInternalType($abc);
    static::assertNotInternalType($def);
    self::assertArraySubset(['a', 'b'], ['c', 'd']);
    $this->assertEquals($a, $b, 'message', 13);
    static::assertEquals($d, $e, 'mess');
    self::assertEquals($f, $g);
    $this->assertNotEquals($h, $i, 'my message', 'bbb');
    static::assertNotEquals($j, $k, 'no way');
    self::assertNotEquals($l, $m);
    $this->assertAttributeInt(345);
    static::attribute(ddd);
    self::attributeEqualTo        ( something);
    $this->readAttribute    (   other);
    static::getStaticAttribute(my::attr);
    self::getObjectAttribute(my->attr);
    $this->assertContains($a, [$b]);
    static::assertNotContains    ($c, [$d]);
    class MyTestListener implements TestListener
    {
      /**
       * @expectedExceptionCode 3
       */
      public function testSomething()
      {
      }
    }
    hash_hmac      ('crc32', 'my_data');
    hash_pbkdf2      ('crc32', 'my_data');
    hash_init       ('crc32',        HASH_HMAC);
