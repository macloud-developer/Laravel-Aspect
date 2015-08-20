<?php
/**
 * for test
 */

namespace __Test;

/**
 * Class AspectCacheable
 *
 * @package __Test
 */
class AspectCacheable
{
    /**
     * @\Cacheable(key="#id")
     * @param null $id
     * @return null
     */
    public function singleKey($id = null)
    {
        return $id;
    }

    /**
     * @\Cacheable(key={"#id","#value"})
     * @param $id
     * @param $value
     * @return mixed
     */
    public function multipleKey($id, $value)
    {
        return $id;
    }

    /**
     * @\Cacheable(cacheNames="testing1",key={"#id","#value"})
     * @param $id
     * @param $value
     * @return mixed
     */
    public function namedMultipleKey($id, $value)
    {
        return $id;
    }

    /**
     * @\Cacheable(cacheNames={"testing1","testing2"},key={"#id","#value"})
     * @param $id
     * @param $value
     * @return mixed
     */
    public function namedMultipleNameAndKey($id, $value)
    {
        return $id;
    }
}
