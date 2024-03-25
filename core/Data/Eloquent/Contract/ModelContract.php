<?php

declare(strict_types=1);

namespace Core\Data\Eloquent\Contract;

use Core\Data\Eloquent\Observers\ModelContractObserver;
use Core\Data\Eloquent\ORMs\HasCreator;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

/**
 * Class ModelContract
 *
 * The ModelContract class serves as the base model for all models in the application.
 * It extends the Laravel Eloquent Model class and provides additional functionalities and features.
 *
 * @package \Core\Data\Eloquent\Contracts
 */
class ModelContract extends Model
{
    use HasFactory, HasCreator, HasUuids, SoftDeletes;
    //use LogsActivity;


    /**
     * The database connection that should be used by the model.
     *
     * @var string
     */
    protected $connection = 'pgsql';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The data type of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $dateFormat = 'Y-m-d H:i:s';

    /**
     * The name of the "created at" column.
     *
     * @var string|null
     */
    public const CREATED_AT = 'created_at';

    /**
     * The name of the "updated at" column.
     *
     * @var string|null
     */
    public const UPDATED_AT = 'updated_at';


    /**
     * The attributes that aren't mass assignable.
     *
     * @var array<int, string>
     */
    public $default_guarded = ['id', 'created_at', 'updated_at', 'deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public $default_fillable = ['status', 'created_at', 'updated_at', 'deleted_at'];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array<int, string>
     */
    public $default_visible = ['id', 'status', 'created_at'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    public $default_casts = [
        'created_at'     => 'datetime:Y-m-d H:i:s',
        'updated_at'     => 'datetime:Y-m-d H:i:s',
        'deleted_at'     => 'datetime:Y-m-d H:i:s',
        'status'         => 'boolean',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array<int, string>
     */
    public $default_hidden = ['status', 'updated_at', 'deleted_at'];


    /**
     * The attributes that should be treated as dates.
     *
     * @var array<int, string>
     */
    protected $dates = [

    ];

    public $default_dates = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    /**
     * The relationships that should be eager loaded when retrieving the model.
     *
     * These relationships will be loaded automatically whenever a model instance
     * is retrieved. Eager loading helps optimize performance by reducing the
     * number of database queries needed to fetch related data.
     *
     * The `$with` property should be an array of relationship names that exist
     * on the model. These relationships will be loaded eagerly when accessing
     * the model instance or when performing a query using the model.
     *
     * @var array<int, string>
     */
    protected $default_with = [];


    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $default_appends = [];


    /**
     * The model's default attribute values.
     *
     * @var array<string, mixed>
     */
    protected $default_attributes = [
        'status' => TRUE
    ];

    /**
     * The event map for the model.
     *
     * @var array<string, string>
     */
    protected $defaultDispatchesEvents = [

    ];

    /**
     * Create a new ModelContract model instance.
     *
     * @param  array  $attributes
     * @return void
     */
    public function __construct(array $attributes = [])
    {

        parent::__construct($attributes);

        $this->attributes       = array_merge($this->default_attributes,       $this->attributes);
        // $this->attributes       = array_merge($this->attributes,               ["{$this->deleteable()}"=> FALSE]);
        if($this->authorable()){
            $this->default_fillable = array_merge($this->default_fillable,         ["{$this->deleteable()}", "{$this->authorable()}"]);
        }
        $this->fillable         = array_merge($this->default_fillable,         $this->fillable);
        $this->guarded          = array_merge($this->default_guarded,          $this->guarded);
        $this->default_appends  = array_merge($this->default_appends,          $this->getAppends());
        $this->appends          = array_merge($this->default_appends,          $this->appends);
        $this->with             = array_merge($this->default_with,             $this->with);

        if($this->authorable()){
            $this->default_hidden   = array_merge($this->default_hidden,          ["{$this->deleteable()}", "{$this->authorable()}"]);
        }

        $this->hidden           = array_merge($this->default_hidden,           $this->hidden);
        
        if($this->authorable()){
            $this->default_casts    = array_merge($this->default_casts,            ["{$this->deleteable()}"=> 'boolean', "{$this->authorable()}"=> 'string']);
        }
        
        $this->casts            = array_merge($this->default_casts,            $this->casts);
        $this->default_visible  = array_merge($this->default_visible,          ["{$this->deleteable()}"]);
        $this->visible          = array_merge($this->default_visible,          $this->visible);
        $this->visible          = array_merge($this->visible,                  $this->appends);
        $this->visible          = array_merge($this->visible,                  $this->with);
        $this->dates            = array_merge($this->default_dates,            $this->dates);
        $this->dispatchesEvents = array_merge($this->defaultDispatchesEvents, $this->dispatchesEvents);
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted(): void
    {
        parent::booted();
    }


    /**
     * The "boot" method of the model.
     *
     * @return void
     */
    protected static function boot(): void
    {
        parent::boot();

        // Apply the StatutScope as a global scope with the default status value of true
        //sstatic::addGlobalScope(new StatutScope(true));

        // Apply the global scope with status = true
        /* static::addGlobalScope('status', function ($query) {
            static::addGlobalScope($query, true);
        }); */

        self::observe(ModelContractObserver::class);
    }

    public function authorable(): ?string
    {
        return "created_by";
    }

    public function deleteable(): string
    {
        return "can_be_delete";
    }

    public function getConditionallyUpdatableAttributes(): array {
        return [];
    }

    public function getUnmodifiableAttributes() {
        return [];
    }

    public function shouldNotBeDeleted(): bool
    {
        if(in_array($this->deleteable(), $this->getFillable())){
            return !$this->{$this->deleteable()};
        }

        return true;
    }

    /**
     * Get the with related relationship.
     *
     * @return array
     */
    public function getRelatedRelationship()
    {
        return $this->with;
    }


    public function getActivitylogOptions(){

        // You can configure additional options here
        return [
            'logOnlyChanged' => true,  // Log only changed attributes
            'logName' => 'custom-log', // Custom log name
            'logAttributes' => ['name', 'email'], // Log only specific attributes
            'logExceptAttributes' => [],
            'logOnlyDirty' => true,
            'logUnguarded' => true, // Log changes to unguarded attributes
            'submitEmptyLogs' => true, // Do not log if no changes were made
            'useLogName' => true, // Use the log name in the activity description
            'defaultLogName' => 'default-log', // Default log name
            //'logEvents' => ['created', 'updated'], // Log specific events
            //'logOnly' => ['created'], // Log only specific events
            //'logExcept' => ['deleted'], // Log all events except specific ones
            'causer' => Auth::user()->id, // Specify the user responsible for the activity
            'subject' => $this->id, // Set the subject (the model) for the activity
        ];
    }
    
}