$(function () {
    let edit = false;
    //Buscar una tarea
    $('#task-result').hide();
    fetchTask();
    $('#search').keyup(function () {
        if ($('#search').val()) {
            let search = $('#search').val();
            $.ajax({
                url: 'task-search.php',
                type: 'POST',
                data: { search },
                success: function (response) {
                    let tasks = JSON.parse(response);
                    let template = '';
                    tasks.map(task => {
                        template += `
                        <li key=${task.id}>
                            <a>${task.name}</a>
                        </li>`
                    });
                    $('#container').html(template);
                    $('#task-result').show();
                }

            });
        } else {
            $('#task-result').hide();
        };
    });

    //Agregar una tarea
    $('#task-form').submit(function (e) {
        e.preventDefault();
        const postData = {
            name: $('#task-name').val(),
            description: $('#task-description').val(),
            id: $('#taskId').val()
        };
        let url = edit === false ? 'task-add.php' : 'task-edit.php';
        console.log(url)
        $.post(url, postData, function (response) {
            console.log(response);
            $('#task-form').trigger('reset');
            fetchTask();
        })
    });

    //Listar tasks
    function fetchTask() {
        $.ajax({
            url: 'task-list.php',
            type: 'GET',
            success: function (response) {
                let tasks = JSON.parse(response);
                let template = '';
                tasks.map(task => {
                    template += `
                    <tr key=${task.id}>
                        <td>${task.id}</td>
                        <td>
                            <a href='#' class='task-item'>${task.name}</a>
                        </td>
                        <td>${task.description}</td>
                        <td>
                            <button class='task-delete btn btn-danger'>Delete</button>
                        </td>
                    </tr>
                    `;
                });
                $('#tasks').html(template);
            }
        })
    };

    //Eliminar tarea
    $(document).on('click', '.task-delete', function () {
        if (confirm('Are you sure you want to delete it?')) {
            let parentTr = $(this).closest('tr');
            let taskId = parentTr.attr('key');
            //Ahora paso al backend
            //Mando la variable id al backend
            $.post('task-delete.php', { id: taskId }, function (response) {
                console.log(response);
                fetchTask();
            })
        }
    });

    //Actualizar tarea
    $(document).on('click', '.task-item', function () {
        console.log('editando')
        let parentTr = $(this).closest('tr');
        let taskId = parentTr.attr('key');
        $.post('task-single.php', { id: taskId }, function (response) {
            const task = JSON.parse(response);
            $('#task-name').val(task.name);
            $('#task-description').val(task.description);
            $('#taskId').val(task.id);
            edit = true;
        });
    });
});