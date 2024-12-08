@foreach($tasks as $v)
        <tr>
          <td>{{$v->title}}</td>
          <td>{{$v->description}}</td>
          <td>{{$v->_user->name}}</td>
          <td>{{$v->_category->name}}</td>
          <td>{{$v->_status->name}}</td>
          <td>{{$v->due_date}}</td>
          <td><a href="{{route('HOME',['id' => $v->id])}}" title="Edit"><i class="bi bi-pen-fill"></i></a> 
          <a href="{{route('D.T',['id' => $v->id])}}" title="Delete"><i class="bi bi-archive-fill"></i></a></td>
        </tr>
        @endforeach