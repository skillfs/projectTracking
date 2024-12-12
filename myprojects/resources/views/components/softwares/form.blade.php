@csrf

<label for="name">Name</label>
<input type="text" name="name" id="name"
    value="{{ old('name', $software->name ?? '') }}">

<label for="descrpition">Description</label>
<textarea name="description" id="description"> {{ old('description', $software->description ?? '') }} </textarea>

<label for="size">Size</label>
<input type="text" name="size" id="size" 
    value="{{ old('size', $software->size ?? '') }}">

<button>Save</button>