<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Application
 *
 * @property int $id
 * @property string $name
 * @property string $client_id
 * @property string $client_secret
 * @property int $date_retention
 * @property string $tld
 * @property string $consumer_name
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Log[] $logs
 * @property-read int|null $logs_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Application newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Application newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Application query()
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereClientSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereConsumerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereDateRetention($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereTld($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereUpdatedAt($value)
 */
	class Application extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Log
 *
 * @property string $id
 * @property int $application_id
 * @property string $service
 * @property string $source
 * @property \Illuminate\Support\Carbon $timestamp
 * @property string $appid
 * @property string $traceid
 * @property string $requestid
 * @property string|null $sessionid
 * @property string|null $locale
 * @property int|null $seqid
 * @property int $offset
 * @property object|null $events
 * @property object|null $request
 * @property object|null $response
 * @property object|null $data
 * @property-read \App\Models\Application $application
 * @method static \Illuminate\Database\Eloquent\Builder|Log newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Log newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Log query()
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereAppid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereApplicationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereEvents($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereOffset($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereRequest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereRequestid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereResponse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereSeqid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereService($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereSessionid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereSource($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereTimestamp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereTraceid($value)
 */
	class Log extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Application[] $applications
 * @property-read int|null $applications_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

