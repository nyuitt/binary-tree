<x-app-layout>
    <div class="container">
        <h1>Criar Novo Usuário</h1>
        
        <!-- Formulário para criar um novo usuário -->
        <form method="POST" action="{{ route('user.create') }}">
            @csrf

            <!-- Campo Nome -->
            <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <!-- Campo Email -->
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <!-- Campo Senha -->
            <div class="form-group">
                <label for="password">Senha</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="points">Pontos</label>
                <input type="number" name="points" class="form-control">
            </div>

            <!-- Campo Posição na Árvore (Esquerda ou Direita) -->
            <div class="form-group">
                <label for="position">Posição</label>
                <select name="position" class="form-control">
                @if ($leftChild != null && $rightChild == null)
                    <option value="right">Direita</option>
                @elseif ($rightChild != null && $leftChild == null)
                    <option value="left">Esquerda</option>
                @elseif ($leftChild == null && $rightChild == null)
                    <option value="left">Esquerda</option>
                    <option value="right">Direita</option>
                @endif       
                </select>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Criar Usuário</button>
        </form>
    </div>
</x-app-layout>
