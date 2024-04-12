<?php


namespace App\Repositories;


use App\Models\User;
use App\Repositories\Extentions\BuilderExtension;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class UserRepository extends AbstractRepository
{
    /** @var BuilderExtension  */
    private $extension;

    /**
     * InformationRepository constructor.
     * @param Application $app
     * @param User $model
     * @param BuilderExtension $extension
     */
    public function __construct(Application $app, User $model, BuilderExtension $extension)
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
            if (isset($search['staff_no']) && !empty($search['staff_no'])) {
                $this->extension->addQuery($this->query,'staff_no',$search['staff_no']);
            }
            if (isset($search['type']) && !empty($search['type'])) {
                $this->extension->addQueryIn($this->query,'type',$search['type']);
            }
        }

        return $this;
    }

    public function find(Request $request)
    {
        return $this
            ->refresh()
            ->search($request)
            ->sort('staff_no')
            ->paginate()
            ->get()
            ;
    }

    public function findAll(Request $request)
    {
        return $this
            ->refresh()
            ->search($request)
            ->sort('staff_no')
            ->collection()
            ->get()
            ;
    }


}
