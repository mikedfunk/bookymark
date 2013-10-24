<?php
/**
 * @package Bookymark
 * @license MIT License <http://opensource.org/licenses/mit-license.html>
 */
namespace MikeFunk\Bookymark\Bookmarks;

use MikeFunk\Bookymark\Interfaces\BookmarkModelInterface;
use Cache;
use Config;
use Eloquent;
use Event;

/**
 * Bookmark
 *
 * @author Michael Funk <mfunk@christianpublishing.com>
 */
class Bookmark extends Eloquent implements BookmarkModelInterface
{

    /**
     * table
     *
     * @var string
     */
    protected $table = 'bookmarks';

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = array(
        'id',
        'title',
        'description',
        'url',
        'user_id',
    );

    /**
     * validation rules
     *
     * @var array
     */
    public $rules = array(
        'title' => 'required',
        'url'   => 'required|url',
    );

    /**
     * getAll
     *
     * @return Bookmark
     */
    public function getAll()
    {
        return self::all();
    }

    /**
     * getById
     *
     * @param int $id
     * @return Bookmark|null
     */
    public function getById($id)
    {
        return self::find($id);
    }

    /**
     * getByIdOrFail
     *
     * @param int $id
     * @return Bookmark|Response
     */
    public function getByIdOrFail($id)
    {
        return self::findOrFail($id);
    }

    /**
     * doStore
     *
     * @return Bookmark
     */
    public function doStore(array $values)
    {
        // instantiate a new bookmark model, insert the passed values, save and
        // return the new model
        $bookmark = self::create($values);
        Event::fire('bookmarks.change');
        return $bookmark;
    }

    /**
     * doUpdate
     *
     * @param array $values
     * @return Bookmark
     */
    public function doUpdate(array $values)
    {
        // ensure the id is set
        if (!isset($values['id'])) {
            throw new \UnexpectedValueException('"id" not set in values array.');
        }
        // instantiate a bookmark model, insert the passed values, save and
        // return the model
        $bookmark = self::find($values['id']);

        // check for existence of bookmark
        if (!$bookmark) {
            throw new \Exception('Item not found. Update not possible.');
        }

        // fill model, save it, fire a hook event, and return the filled model
        $bookmark = $bookmark->fill($values);
        $bookmark->save();
        Event::fire('bookmarks.change');
        return $bookmark;
    }

    /**
     * doDelete
     *
     * @param int $id
     * @return Bookmark
     */
    public function doDelete($id)
    {
        // @TODO throw exception on bookmark not found
        $bookmark = self::find($id)->delete();
        Event::fire('bookmarks.change');
        return $bookmark;
    }

    /**
     * getByUserId
     *
     * @return Bookmark
     */
    public function getByUserId($id)
    {
        // get the record, put it in the cache, return it
        return self::where('user_id', '=', $id)
            ->paginate(Config::get('bookymark.per_page'));
    }
}
