<?php


namespace App\Repositories\Traits;


trait PublicFindTrait
{
    /**
     * 表示許可
     * @param $search
     * @return $this
     */
    protected function isDisplay()
    {
        $this->extension->addQuery($this->query, 'is_not_display', '0');

        return $this;
    }

}
