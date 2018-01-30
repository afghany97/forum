<div class="container">

        <div class="row">
        
            <div class="col-md-8 col-md-offset-2">
     
                <form action="{{$thread->path() . '/replies'}}" method="POST">

                    {{csrf_field()}}
                    
                    <textarea class="form-control" placeholder="leave a reply..." id="body" name="body" rows="4"></textarea>

                    <button type="submit" class="btn btn-defualt">Submit</button>

                </form>

            </div>
        
        </div>

</div>