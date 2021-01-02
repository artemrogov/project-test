<x-app-layout>
<form>
        <div class="form-group">
            <label for="exampleFormControlInput1">Name</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Enter Name" wire:model="title">
            @error('name') <span class="text-danger">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <label for="exampleFormControlInput2">Email address</label>
            <input type="text" class="form-control" id="exampleFormControlInput2" wire:model="description" >
            @error('description') <span class="text-danger">{{ $description }}</span>@enderror
        </div>

        <button wire:click.prevent="createDocument()" class="btn btn-success">Сохранить</button>
</form>
</x-app-layout>
