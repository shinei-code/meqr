<?php


namespace App\Repositories;


use App\Models\Insurance;
use App\Repositories\Extentions\BuilderExtension;
use App\Repositories\Traits\PublicFindTrait;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class InsuranceRepository extends AbstractRepository
{
    use PublicFindTrait;

    /** @var BuilderExtension  */
    private $extension;

    /**
     * InformationRepository constructor.
     * @param Application $app
     * @param Insurance $model
     * @param BuilderExtension $extension
     */
    public function __construct(Application $app, Insurance $model, BuilderExtension $extension)
    {
        $this->model = $model;
        $this->request = $app->make('Illuminate\Http\Request');
        $this->query = $this->model->newQuery();
        $this->extension = $extension;
    }

    protected function search(Request $request)
    {
        if($request->has('search')) {
            $search = $request->get('search');

            if (isset($search['name']) && !empty($search['name'])) {
                $this->extension->addQueryLike($this->query,'name',$search['name']);
            }
            if (isset($search['code']) && !empty($search['code'])) {
                $this->extension->addQuery($this->query,'code',$search['code']);
            }
            if (isset($search['type']) && !empty($search['type'])) {
                $this->extension->addQueryIn($this->query,'type',$search['type']);
            }
        }

        return $this;
    }

    protected function type($type)
    {
        $this->extension->addQuery($this->query,'type', $type);

        return $this;
    }

    protected function code($code)
    {
        $this->extension->addQuery($this->query,'code', $code);

        return $this;
    }

    public function findCount(Request $request)
    {
        return $this
            ->refresh()
            ->search($request)
            ->count()
            ;

    }

    public function find(Request $request)
    {
        return $this
            ->refresh()
            ->search($request)
            ->sort('id')
            ->paginate()
            ->get()
            ;
    }

    public function findPublic(Request $request)
    {
        return $this
            ->refresh()
            ->search($request)
            ->isDisplay()
            ->sort('id')
            ->collection()
            ->get()
            ;
    }

    public function findAll(Request $request)
    {
        return $this
            ->refresh()
            ->search($request)
            ->sort('id')
            ->collection()
            ->get()
            ;
    }

    public function findType($type)
    {
        return $this
            ->refresh()
            ->type($type)
            ->isDisplay()
            ->sort('id')
            ->collection()
            ->get()
            ;
    }

    public function findCode($code)
    {
        return $this
            ->refresh()
            ->code($code)
            ->isDisplay()
            ->sort('id')
            ->collection()
            ->first()
            ;
    }
}
