@section('title', 'Title')
<x-app>
    <h3 class="page-title">コード登録</h3>
        @include('components.session')
        @include('components.form-error')
            @if(empty($code->id))
            {!! Form::model($code, ['route' => ['code.store'], 'class' => '', 'accept-charset' => 'utf-8']) !!}
            @else
            {!! Form::model($code, ['route' => ['code.update', $code], 'class' => '', 'accept-charset' => 'utf-8','method' => 'put']) !!}
            @endif
    <div class="ms-2">
        <!-- カテゴリ -->
        <div class="mb-4">
            <label for="category" class="form-label label-sm">
                カテゴリ<span class="required">必須</span>
            </label>
            {!! Form::text('category', old('category'), ['required' => 'required','class' => 'form-control w-50','id'=>'category']) !!}
        </div>
        <!-- キー -->
        <div class="mb-4">
            <label for="key" class="form-label label-sm">
                キー<span class="required">必須</span>
            </label>
            {!! Form::text('key', old('key'), ['required' => 'required','class' => 'form-control w-50','id'=>'key']) !!}
        </div>
        <!-- 値 -->
        <div class="mb-4">
            <label for="value1" class="form-label label-sm">
                値<span class="required">必須</span>
            </label>
            {!! Form::text('value', old('value'), ['required' => 'required','class' => 'form-control w-50','id'=>'value1']) !!}
        </div>
        <!-- 値2 -->
        <div class="mb-4">
            <label for="value2" class="form-label label-sm">値２</label>
            {!! Form::text('sub_value', old('sub_value'), ['class' => 'form-control w-50','id'=>'value2']) !!}
        </div>
        <!-- 表示順 -->
        <div class="mb-4">
            <label for="order" class="form-label label-sm">表示順</label>
            {!! Form::text('display_order', old('display_order'), ['class' => 'form-control w-50','id'=>'order']) !!}
        </div>

        <!-- 表示/非表示 -->
        <div class="label-sm mb-2">表示／非表示</div>
        <div class="form-check ms-3">
            <label class="form-check-label">
                {!! Form::booleanbox('is_not_display', 1, old('is_not_display', $code->is_not_display) == 1, ['class' => 'form-check-input']) !!}
                非表示
            </label>
        </div>
    </div>
    <!-- 画面遷移ボタン -->
    <div class="row mt-3 mb-5 ms-2 d-flex justify-content-center">
        <div class="col-3">
            @if(empty($code->id))
                <input class="btn search-btn me-2 w-100" name="submit" value="登録" type="submit" id="form_submit"/>
            @else
                <input class="btn search-btn me-2 w-100" name="submit" value="更新する" type="submit" id="form_submit"/>
            @endif
        </div>
        <div class="col-2">
            <a href="{{ route('code.index') }}"><button type="button" class="btn btn-outline-secondary clear-btn w-100">キャンセル</button></a>
        </div>
    </div>
        {!! Form::close() !!}
</x-app>
