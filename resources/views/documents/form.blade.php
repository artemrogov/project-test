<div class="form-group row">
    <label class="col-md-3 col-form-label" for="text-input">Название документа</label>
    <div class="col-md-9">
        <input class="form-control" id="text-input" type="text" name="title" value="{{old('title',$document->title ?? '')}}" placeholder="Text"><span class="help-block">Название документа</span>
    </div>
</div>
<div class="form-group row">
    <label class="col-md-3 col-form-label" for="description">Краткое описание документа</label>
    <div class="col-md-9">
        <textarea class="form-control" id="description" name="description" rows="6" placeholder="Введите описание документа">{{old('description',$document->description ?? '')}}</textarea>
    </div>
</div>
<div class="form-group row">
    <label class="col-md-3 col-form-label" for="date-input">Дата публикации</label>
    <div class="col-md-9">
        <input class="form-control" id="date-input" type="date" name="date-input" placeholder="date"><span class="help-block">Please enter a valid date</span>
    </div>
</div>
<div class="form-group row">
    <label class="col-md-3 col-form-label" for="date-input">Дата окончания публикации</label>
    <div class="col-md-9">
        <input class="form-control" id="date-input" type="date" name="date-input" placeholder="date"><span class="help-block">Please enter a valid date</span>
    </div>
</div>
<div class="form-group row">
    <label class="col-md-3 col-form-label" for="textarea-input">Содержание документа</label>
    <div class="col-md-9">
        <textarea class="form-control" id="textarea-input" name="content" rows="9" placeholder="Content..">{{old('content',$document->content ?? '')}}</textarea>
    </div>
</div>
<div class="form-check form-check-inline mr-1">
    <input class="form-check-input" id="inline-checkbox1" type="checkbox" name="active" value="1" {{old('active',$document->active  ?? '') == "1" ? 'checked' : ''}} >
    <label class="form-check-label" for="inline-checkbox1">Активировать</label>
</div>
<div class="form-group row">
    <label class="col-md-3 col-form-label" for="select1">Тип документа</label>
    <div class="col-md-9">
        <select class="form-control" id="select1" name="select1">
            <option value="0">Please select</option>
            <option value="1">Option #1</option>
            <option value="2">Option #2</option>
            <option value="3">Option #3</option>
        </select>
    </div>
</div>
