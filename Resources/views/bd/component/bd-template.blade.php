<div class="container-bd">
   
    @foreach($db as $items)
        <div class="bd_list">   
            <div class="nombre_de_la_bd">
               {{$items->nombre}}
            </div>
            <div class="option_bd">
                <span>
                    <i class="bi bi-eye"></i>
                </span>
                <span>
                    <i class="bi bi-eye"></i>
                </span>
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="red" class="bi bi-trash3" viewBox="0 0 16 16">
                        <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
                    </svg>
                </span>
            </div>
        </div>
    @endforeach
   
    
</div>
<style>
    .nombre_de_la_bd{
       
    }
    .option_bd{
        display: flex;
        gap: 20px;
        justify-content: flex-end;
        align-items: flex-end;  
    }
    .bd_list{
       margin-top:10px; 
        width: 381px;
        height: 36px;
       
        border-bottom: solid 1px rgba(0, 0, 0 , .2);
        display: flex;
        justify-content: space-between;
    }
    .container-bd{
        padding-top:80px; 
        display: flex;
        justify-content:start;
        overflow-y: scroll;
        flex-direction: column;
        align-items: center;
        width: 469px;
        height: 400px;
        
        margin-top:10px; 
    }
</style>