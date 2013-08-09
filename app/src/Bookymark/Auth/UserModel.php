<?php
/**
 * @package Bookymark
 * @license MIT License <http://opensource.org/licenses/mit-license.html>
 */
namespace Bookymark\Auth;

use User;

/**
 * UserModel
 *
 * @author Michael Funk <mfunk@christianpublishing.com>
 */
class UserModel extends User
{
    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = array(
        'email',
        'password',
        'register_token',
    );
}
