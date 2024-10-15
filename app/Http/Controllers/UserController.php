<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {


        // ----- daqui para baixo exibe somente filhos
       //$users = User::where('parent_id', Auth::user()->id)->get();

        // ---- daqui para baixo, exibe tanto filhos quanto netos
        $parent = Auth::user();

      
        $users = $this->getAllDescendants($parent);
        //dd($users);

        return view('user.index', [ 
            'users'=> $users,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

        

        $me = Auth::user();

        $leftChild = $me->left_child_id;
        $rightChild = $me->right_child_id;

        if($leftChild != null and $rightChild != null){
            return redirect()->route('user.index')->with('error','Você atingiu o limite de afiliados');
        }
    
        if($request->method() == 'POST'){
            $user = new User();

            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->parent_id = Auth::user()->id;
            $user->points = $request->points;
            $user->position = $request->position;
            $user->save();

         
            if ($request->position == 'left') {
                $me->left_child_id = $user->id;  
            } elseif ($request->position == 'right') {
                $me->right_child_id = $user->id;
            }

            $me->points += $user->points;
            $me->save();  // Salva as alterações no pai

            return redirect()->route('user.index')->with('success','Usuário criado com sucesso');
        }

        return view('user.create', ['leftChild'=> $leftChild,'rightChild'=> $rightChild]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
       
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        $users = User::all();

        if($request ->method() == 'POST'){
            
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->parent_id = Auth::user()->id;
            $user->save();

            return redirect("/users/edit/$user->id")->with("success", 'Usuário editado com sucesso');
        }
        return view('user.edit', ['user'=> $user, 'users'=> $users]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $userPosition = $user->position;
        $me = Auth::user();

        if (!$user){
            return response()->json(['message' => 'Usuário não encontrado'], 404);
        }

        $me->points -= $user->points;

        if($userPosition == 'right'){
            $me->right_child_id = null;
        }elseif($userPosition == 'left'){
            $me->left_child_id = null;
        }
        $me->save();

        $user->delete();

        return redirect('/users')->with('success','Usuário deletado com sucesso');
    }

    private function getAllDescendants(User $user)
    {
      
        $children = User::where('parent_id', $user->id)->get();

        $allDescendants = collect($children); 

        foreach ($children as $child) {
            $allDescendants = $allDescendants->merge($this->getAllDescendants($child));
        }

        return $allDescendants; 
    }

    public function calculatePoints()
    {
     
        $parent = Auth::user();

        // Obter todos os descendentes
        $descendants = $this->getAllDescendants($parent);

        // Obter somente seu filho direto
       // $descendants = User::where('parent_id', Auth::user()->id)->get();


      
        $totalPoints = $descendants->sum('points'); 

    
        $parent->points = $totalPoints;
        $parent->save();

        return redirect()->route('user.index')->with('success', 'Pontos recalculados com sucesso!');
    }
}
