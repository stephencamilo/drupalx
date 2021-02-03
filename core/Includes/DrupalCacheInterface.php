<?php
namespace Core\Includes;

interface DrupalCacheInterface {

    /**
     * Returns data from the persistent cache.
     *
     * Data may be stored as either plain text or as serialized data. cache_get()
     * will automatically return unserialized objects and arrays.
     *
     * @param $cid
     *   The cache ID of the data to retrieve.
     *
     * @return
     *   The cache or FALSE on failure.
     */
    function get($cid);
  
    /**
     * Returns data from the persistent cache when given an array of cache IDs.
     *
     * @param $cids
     *   An array of cache IDs for the data to retrieve. This is passed by
     *   reference, and will have the IDs successfully returned from cache
     *   removed.
     *
     * @return
     *   An array of the items successfully returned from cache indexed by cid.
     */
     function getMultiple(&$cids);
  
    /**
     * Stores data in the persistent cache.
     *
     * @param $cid
     *   The cache ID of the data to store.
     * @param $data
     *   The data to store in the cache. Complex data types will be automatically
     *   serialized before insertion. Strings will be stored as plain text and not
     *   serialized. Some storage engines only allow objects up to a maximum of
     *   1MB in size to be stored by default. When caching large arrays or
     *   similar, take care to ensure $data does not exceed this size.
     * @param $expire
     *   (optional) Controls the maximum lifetime of this cache entry. Note that
     *   caches might be subject to clearing at any time, so this setting does not
     *   guarantee a minimum lifetime. With this in mind, the cache should not be
     *   used for data that must be kept during a cache clear, like sessions.
     *
     *   Use one of the following values:
     *   - CACHE_PERMANENT: Indicates that the item should never be removed unless
     *     explicitly told to using cache_clear_all() with a cache ID.
     *   - CACHE_TEMPORARY: Indicates that the item should be removed at the next
     *     general cache wipe.
     *   - A Unix timestamp: Indicates that the item should be kept at least until
     *     the given time, after which it behaves like CACHE_TEMPORARY.
     */
    function set($cid, $data, $expire = CACHE_PERMANENT);
  
  
    /**
     * Expires data from the cache.
     *
     * If called without arguments, expirable entries will be cleared from the
     * cache_page and cache_block bins.
     *
     * @param $cid
     *   If set, the cache ID or an array of cache IDs. Otherwise, all cache
     *   entries that can expire are deleted. The $wildcard argument will be
     *   ignored if set to NULL.
     * @param $wildcard
     *   If TRUE, the $cid argument must contain a string value and cache IDs
     *   starting with $cid are deleted in addition to the exact cache ID
     *   specified by $cid. If $wildcard is TRUE and $cid is '*', the entire
     *   cache is emptied.
     */
    function clear($cid = NULL, $wildcard = FALSE);
  
    /**
     * Checks if a cache bin is empty.
     *
     * A cache bin is considered empty if it does not contain any valid data for
     * any cache ID.
     *
     * @return
     *   TRUE if the cache bin specified is empty.
     */
    function isEmpty();
  }