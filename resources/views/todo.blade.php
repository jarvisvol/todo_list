<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Modal Styles */
        .modal {
            width: 25%;
            height: 30%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .modal-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
            position: relative;
        }

        .close-button {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
            font-size: 20px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h2>To-Do List</h2>

        <!-- Display error message for 'task' field -->
        @error('todo')
            <div style="color: red;">
                {{ $message }}
            </div>
        @enderror

        <!-- Form to add new task -->
        <form action="{{ route('todos.store') }}" method="POST" class="mb-3">
            @csrf
            <div class="input-group">
                <input type="text" name="todo" class="form-control" placeholder="New Task">
                <button class="btn btn-primary" type="submit">Add</button>
            </div>
        </form>

        <form action="{{ route('todo.showAll') }}" method="GET">
            @csrf
            <button class="btn btn-primary" style="margin:10px" type="submit">See All Todos</button>
        </form>

        <!-- Confirmation Modal -->
        <div id="confirmModal" class="modal" style="display: none;">
            <div class="modal-content">
                <span class="close-button" onclick="closeModal()">&times;</span>
                <p>Are you sure you want to delete this item?</p>
                <button id="confirmDeleteBtn" class="btn btn-danger">Delete</button>
                <button class="btn btn-secondary" onclick="closeModal()">Cancel</button>
            </div>
        </div>

        <!-- List of tasks -->
        <ul class="list-group">
            @foreach($todos as $todo)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span style="{{ $todo->is_completed ? 'text-decoration: line-through;' : '' }}">
                        {{ $todo->name }}
                    </span>

                    <div>
                        <!-- Mark as completed button -->
                        @if(!$todo->is_completed)
                            <form action="{{ route('todos.update', parameters: $todo->id) }}" method="POST"
                                class="d-inline-block">
                                @csrf
                                @method('PUT')
                                <button class="btn btn-success btn-sm">Mark as Completed</button>
                            </form>
                        @endif

                        <!-- Delete button -->
                        <form action="{{ route('todos.destroy', $todo->id) }}" method="POST"
                            class="d-inline-block confirm-delete">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let formToSubmit = null;

        function showModal(form) {
            formToSubmit = form;
            document.getElementById('confirmModal').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('confirmModal').style.display = 'none';
            formToSubmit = null;
        }

        function confirmDelete(event) {
            event.preventDefault(); // Prevent the form from submitting immediately
            showModal(event.target.closest('form'));
        }

        document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
            if (formToSubmit) {
                formToSubmit.submit();
            }
        });

        // Attach the confirmDelete function to forms with class 'confirm-delete'
        document.querySelectorAll('form.confirm-delete').forEach(function (form) {
            form.addEventListener('submit', confirmDelete);
        });
    </script>
</body>

</html>
