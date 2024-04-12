<?php


namespace App\Repositories;


use App\Models\Code;
use App\Repositories\Extentions\BuilderExtension;
use App\Repositories\Traits\PublicFindTrait;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class CodeRepository extends AbstractRepository
{
    use PublicFindTrait;

    /** @var BuilderExtension  */
    private $extension;

    /**
     * InformationRepository constructor.
     * @param Application $app
     * @param Code $model
     * @param BuilderExtension $extension
     */
    public function __construct(Application $app, Code $model, BuilderExtension $extension)
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

            if (isset($search['category']) && !empty($search['category'])) {
                $this->extension->addQueryLike($this->query,'category',$search['category']);
            }
        }

        return $this;
    }

    protected function category($category)
    {
        $this->extension->addQuery($this->query,'category', $category);

        return $this;
    }

    protected function key($key)
    {
        $this->extension->addQuery($this->query,'key', $key);

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
            ->orderBy('category')
            ->orderBy('display_order')
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
            ->orderBy('category')
            ->orderBy('display_order')
            ->collection()
            ->get()
            ;
    }


    public function findAll(Request $request)
    {
        return $this
            ->refresh()
            ->search($request)
            ->orderBy('category')
            ->orderBy('display_order')
            ->collection()
            ->get()
            ;
    }

    public function findCategory($category)
    {
        return $this
            ->refresh()
            ->category($category)
            ->isDisplay()
            ->sort('id')
            ->collection()
            ->get()
            ;
    }

    public function findOne($category, $key)
    {
        return $this
            ->refresh()
            ->category($category)
            ->isDisplay()
            ->key($key)
            ->sort('id')
            ->collection()
            ->first()
            ;
    }
}
