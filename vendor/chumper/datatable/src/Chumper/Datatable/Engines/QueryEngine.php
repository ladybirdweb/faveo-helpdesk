<?php namespace Chumper\Datatable\Engines;

use Chumper\Datatable\Datatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Collection;

class QueryEngine extends BaseEngine {

    /**
     * @var Builder
     */
    public $builder;
    /**
     * @var Builder
     */
    public $originalBuilder;

    /**
     * @var array single column searches
     */
    public $columnSearches = array();

    /**
     * @var Collection the returning collection
     */
    private $resultCollection;

    /**
     * @var Collection the resulting collection
     */
    private $collection = null;

    /**
     * @var array Different options
     */
    protected $options = array(
        'searchOperator'    =>  'LIKE',
        'searchWithAlias'   =>  false,
        'orderOrder'        =>  null,
        'counter'           =>  0,
        'noGroupByOnCount'  =>  false,
    );

    function __construct($builder)
    {
        parent::__construct();
        if($builder instanceof Relation)
        {
            $this->builder = $builder->getBaseQuery();
            $this->originalBuilder = clone $builder->getBaseQuery();
        }
        else
        {
            $this->builder = $builder;
            $this->originalBuilder = clone $builder;
        }
    }

    public function count()
    {
        return $this->options['counter'];
    }

    public function totalCount()
    {
        // Store temporary copy as we may modify it, we'd be stupid to modify
        // the actual "original" copy...
        $originalBuilder = $this->originalBuilder;

        if ($this->options['noGroupByOnCount']) {
            $originalBuilder = $this->removeGroupBy($originalBuilder);
        }

        return $originalBuilder->count();
    }

    public function getArray()
    {
        return $this->getCollection($this->builder)->toArray();
    }

    public function reset()
    {
        $this->builder = $this->originalBuilder;
        return $this;
    }


    public function setSearchOperator($value = "LIKE")
    {
        $this->options['searchOperator'] = $value;
        return $this;
    }

    public function setSearchWithAlias()
    {
        $this->options['searchWithAlias'] = true;
        return $this;
    }

    public function setNoGroupByOnCount()
    {
        $this->options['noGroupByOnCount'] = true;
        return $this;
    }

    //--------PRIVATE FUNCTIONS

    protected function internalMake(Collection $columns, array $searchColumns = array())
    {
        $builder = clone $this->builder;
        $countBuilder = clone $this->builder;

        $builder = $this->doInternalSearch($builder, $searchColumns);
        $countBuilder = $this->doInternalSearch($countBuilder, $searchColumns);

        if($this->options['searchWithAlias'])
        {
            $this->options['counter'] = count($countBuilder->get());
        }
        else
        {
            // Remove the GROUP BY clause for the count
            if ($this->options['noGroupByOnCount']) {
                $countBuilder = $this->removeGroupBy($countBuilder);
            }
            $this->options['counter'] = $countBuilder->count();
        }

        $builder = $this->doInternalOrder($builder, $columns);
        $collection = $this->compile($builder, $columns);

        return $collection;
    }

    /**
     * Remove the GROUP BY clause from a builder.
     *
     * @param Builder|QueryBuilder $builder
     * @return Builder|QueryBuilder $builder with the groups property set to null.
     */
    private function removeGroupBy($builder)
    {
        // Handle \Illuminate\Database\Eloquent\Builder
        if ($builder instanceof Builder) {
            $query = $builder->getQuery();
            $query->groups = null;
            $builder->setQuery($query);
        }
        // Handle \Illuminate\Database\Query\Builder
        else {
            $builder->groups = null;
        }

        return $builder;
    }

    /**
     * @param $builder
     * @return Collection
     */
    private function getCollection($builder)
    {
        if($this->collection == null)
        {
            if($this->skip > 0)
            {
                $builder = $builder->skip($this->skip);
            }
            if($this->limit > 0)
            {
                $builder = $builder->take($this->limit);
            }
            //dd($this->builder->toSql());
            $this->collection = $builder->get();

            if(is_array($this->collection))
                $this->collection = new Collection($this->collection);
        }
        return $this->collection;
    }

    private function doInternalSearch($builder, $columns)
    {
        if (!empty($this->search)) {
            $this->buildSearchQuery($builder, $columns);
        }

        if (!empty($this->columnSearches)) {
            $this->buildSingleColumnSearches($builder);
        }

        return $builder;
    }
    protected function buildSearchQuery($builder, $columns)
    {
        $like = $this->options['searchOperator'];
        $search = $this->search;
        $exact = $this->exactWordSearch;
        $builder = $builder->where(function($query) use ($columns, $search, $like, $exact) {
            foreach ($columns as $c) {
                //column to search within relationships : relatedModel::column
                if(strrpos($c, '::')) {
                    $c = explode('::', $c);
                    $query->orWhereHas($c[0], function($q) use($c, $like, $exact, $search){
                        $q->where($c[1], $like, $exact ? $search : '%' . $search . '%');
                    });
                }
                //column to CAST following the pattern column:newType:[maxlength]
                elseif(strrpos($c, ':')){
                    $c = explode(':', $c);
                    if(isset($c[2]))
                        $c[1] .= "($c[2])";
                    $query->orWhereRaw("cast($c[0] as $c[1]) ".$like." ?", array($exact ? "$search" : "%$search%"));
                }
                else
                    $query->orWhere($c, $like, $exact ? $search : '%' . $search . '%');
            }
        });
        return $builder;
    }

    /**
     * @param $builder
     * Modified by sburkett to facilitate individual exact match searching on individual columns (rather than for all columns)
     */

    private function buildSingleColumnSearches($builder)
    {
        foreach ($this->columnSearches as $index => $searchValue) {
            if(@$this->columnSearchExact[ $this->fieldSearches[$index] ] == 1) {
                $builder->where($this->fieldSearches[$index], '=', $searchValue );
            } else {
                $builder->where($this->fieldSearches[$index], $this->options['searchOperator'], '%' . $searchValue . '%');
            }
        }

    }

    private function compile($builder, $columns)
    {
        $this->resultCollection = $this->getCollection($builder);

        $self = $this;
        $this->resultCollection = $this->resultCollection->map(function($row) use ($columns,$self) {
            $entry = array();
            // add class and id if needed
            if(!is_null($self->getRowClass()) && is_callable($self->getRowClass()))
            {
                $entry['DT_RowClass'] = call_user_func($self->getRowClass(),$row);
            }
            if(!is_null($self->getRowId()) && is_callable($self->getRowId()))
            {
                $entry['DT_RowId'] = call_user_func($self->getRowId(),$row);
            }
            if(!is_null($self->getRowData()) && is_callable($self->getRowData()))
            {
                $entry['DT_RowData'] = call_user_func($self->getRowData(),$row);
            }
            $i = 0;
            foreach ($columns as $col)
            {
                if($self->getAliasMapping())
                {
                    $entry[$col->getName()] =  $col->run($row);
                }
                else
                {
                    $entry[$i] =  $col->run($row);
                }
                $i++;
            }
            return $entry;
        });
        return $this->resultCollection;
    }

    private function doInternalOrder($builder, $columns)
    {
        //var_dump($this->orderColumn);
        if(!is_null($this->orderColumn))
        {
            $i = 0;
            foreach($columns as $col)
            {

                if($i === (int) $this->orderColumn[0])
                {
                    if(strrpos($this->orderColumn[1], ':')){
                        $c = explode(':', $this->orderColumn[1]);
                        if(isset($c[2]))
                            $c[1] .= "($c[2])";
                        $builder = $builder->orderByRaw("cast($c[0] as $c[1]) ".$this->orderDirection);
                    }
                    else
                        $builder = $builder->orderBy($col->getName(), $this->orderDirection);
                    return $builder;
                }
                $i++;
            }
        }
        return $builder;
    }
}