$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    let currentPage = 1;

    function loadUsers(page = 1) {
        $.ajax({
            url: `/dash/usuarios/list/${page}`,
            method: "GET",
            success: function (response) {
                const users = response.users;
                const currentPage = response.current_page;
                const lastPage = response.last_page;

                $("#user-list").empty();

                users.forEach((user) => {
                    $("#user-list").append(`
                                <tr>
                                    <td>${user.id}</td>
                                    <td>${user.name}</td>
                                    <td>${user.email}</td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input toggle-status A_statsUpdate" type="checkbox" 
                                                data-id="${user.id}" ${
                        user.stats ? "checked" : ""
                    }>
                                        </div>
                                    </td>
                                    <td>
                                        <a class="btn btn-sm btn-primary me-1 edit-user" href="/dash/usuarios/${
                                            user.id
                                        }/editar">Editar</a>
                                        <button class="btn btn-sm btn-danger delete-user" data-id="${
                                            user.id
                                        }">Excluir</button>
                                    </td>
                                </tr>
                            `);
                });

                let paginationHtml = "";
                for (let i = 1; i <= lastPage; i++) {
                    paginationHtml += `
                                <li class="page-item A_userPage" data-page="${i}" style="${
                        i === currentPage
                            ? 'style="background-color: white;color: blue;border-color: lightblue;"'
                            : ""
                    }">
                                    <a class="page-link" href="#">${i}</a>
                                </li>
                            `;
                }
                $("#pagination").html(`
                            <nav aria-label="Page navigation">
                                <ul class="pagination">
                                    ${paginationHtml}
                                </ul>
                            </nav>
                        `);
            },
            error: function () {
                alert("Erro ao carregar os dados!");
            },
        });
    }

    loadUsers(currentPage);

    $("body").on("click", ".A_statsUpdate", function () {
        var user = $(this).attr("data-id");
        var val = $(this).val();
        $.ajax({
            url: `/dash/usuarios/stats/${user}/${val}`,
            method: "POST",
            success: function (res) {
                console.log(res.message);
                loadUsers();
            },
            error: function () {
                alert("Erro ao desativar o usuário.");
            },
        });
    });

    $("body").on("click", ".A_userPage", function () {
        var pag = $(this).attr("data-page");
        loadUsers(pag);
    });

    $("body").on("click", ".delete-user", function () {
        const userId = $(this).data("id");
        if (confirm("Deseja realmente excluir este usuário?")) {
            $.ajax({
                url: `/dash/usuarios/delete/${userId}`,
                method: "POST",
                data: {
                    _method: "DELETE",
                },
                success: function () {
                    loadUsers();
                },
                error: function () {
                    alert("Erro ao excluir usuário");
                },
            });
        }
    });

    let currentTaskPage = 1;

    function loadTasks(page = 1) {
        $.ajax({
            url: `/dash/tarefas/list/${page}`,
            method: "GET",
            success: function (response) {
                const tasks = response.tasks;
                const currentTaskPage = response.current_page;
                const lastPage = response.last_page;

                $("#task-list").empty();

                tasks.forEach((task) => {
                    let statusMsg = "";

                    switch (task.status) {
                        case 1:
                            statusMsg = `
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    Em andamento
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item A_taskStatus" style="cursor:pointer" data-task="${task.id}" data-status="2">Concluído</a></li>
                                    <li><a class="dropdown-item A_taskStatus" style="cursor:pointer" data-task="${task.id}" data-status="3">Cancelado</a></li>
                                </ul>
                            </div>`;
                            break;
                        case 2:
                            statusMsg = `
                            <div class="btn-group">
                                <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    Concluído
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item A_taskStatus" style="cursor:pointer" data-task="${task.id}" data-status="1">Em andamento</a></li>
                                    <li><a class="dropdown-item A_taskStatus" style="cursor:pointer" data-task="${task.id}" data-status="3">Cancelado</a></li>
                                </ul>
                            </div>`;
                            break;
                        case 3:
                            statusMsg = `
                            <div class="btn-group">
                                <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    Cancelado
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item A_taskStatus" style="cursor:pointer" data-task="${task.id}" data-status="1">Em andamento</a></li>
                                    <li><a class="dropdown-item A_taskStatus" style="cursor:pointer" data-task="${task.id}" data-status="2">Concluído</a></li>
                                </ul>
                            </div>`;
                            break;
                        default:
                            statusMsg = `
                            <div class="btn-group">
                                <button type="button" class="btn btn-warning dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    Desconhecido
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item A_taskStatus" style="cursor:pointer" data-task="${task.id}" data-status="1">Em andamento</a></li>
                                    <li><a class="dropdown-item A_taskStatus" style="cursor:pointer" data-task="${task.id}" data-status="2">Concluído</a></li>
                                    <li><a class="dropdown-item A_taskStatus" style="cursor:pointer" data-task="${task.id}" data-status="3">Cancelado</a></li>
                                </ul>
                            </div>`;
                    }
                    $("#task-list").append(`
                                <tr>
                                    <td>${task.id}</td>
                                    <td>${task.title}</td>
                                    <td>${statusMsg}</td>
                                    <td>
                                        <a class="btn btn-sm btn-primary me-1 edit-user" href="/dash/tarefas/${task.id}/editar">Editar</a>
                                        <button class="btn btn-sm btn-danger A_deleteTask" data-id="${task.id}">Excluir</button>
                                        <a class="btn btn-sm btn-primary me-1 edit-user" href="/dash/tarefas/${task.id}/visualizar">Visualizar</a>
                                    </td>
                                </tr>
                            `);
                });

                let paginationHtml = "";
                for (let i = 1; i <= lastPage; i++) {
                    paginationHtml += `
                                <li class="page-item A_userPage" data-page="${i}" style="${
                        i === currentTaskPage
                            ? 'style="background-color: white;color: blue;border-color: lightblue;"'
                            : ""
                    }">
                                    <a class="page-link" href="#">${i}</a>
                                </li>
                            `;
                }
                $("#pagination").html(`
                            <nav aria-label="Page navigation">
                                <ul class="pagination">
                                    ${paginationHtml}
                                </ul>
                            </nav>
                        `);
            },
            error: function () {
                alert("Erro ao carregar os dados!");
            },
        });
    }

    loadTasks(currentTaskPage);

    $("body").on("click", ".A_taskStatus", function () {
        var task = $(this).attr("data-task");
        var status = $(this).attr("data-status");
        $.ajax({
            url: `/dash/tarefas/status/${task}/${status}`,
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (res) {
                console.log(res.message);
                setTimeout(function () {
                    location.reload();
                }, 1000);
            },
            error: function () {
                alert("Erro ao atualizar a tarefa.");
            },
        });
    });

    $("body").on("click", ".A_incluirParticipante", function () {
       var task = $(this).attr("data-task");
        var email = $("#A_emailParticipante").val();

        $.ajax({
            url: `/dash/tarefas/${task}/participante`,
            method: "POST",
            data: {
                email: email
            },
            success: function(response) {
                $('.A_msg').html('<div class="alert alert-success">' + response.message + '</div>');
                setTimeout(function () {
                    location.reload();
                }, 2000);
            },
            error: function(xhr) {
                let msg = 'Erro ao processar a requisição.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }
                $('.A_msg').html('<div style="color:red;">' + msg + '</div>');
            }
        });
    });

    $("body").on("click", ".A_removeTaskUser", function () {
        const task = $(this).attr("data-task");
        const user = $(this).attr("data-user");
        if (confirm("Deseja realmente remover este usuário?")) {
            $.ajax({
                url: `/dash/tarefas/remove/${task}/${user}`,
                method: "POST",
                data: {
                    _method: "DELETE",
                },
                success: function () {
                    $(`#user${user}`).remove();
                },
                error: function () {
                    alert("Erro ao remover usuário");
                },
            });
        }
    });

    $("body").on("click", ".A_deleteTask", function () {
        const task = $(this).data("id");
        if (confirm("Deseja realmente excluir esta tarefa?")) {
            $.ajax({
                url: `/dash/tarefas/delete/${task}`,
                method: "POST",
                data: {
                    _method: "DELETE",
                },
                success: function () {
                    loadTasks();
                },
                error: function () {
                    alert("Erro ao excluir tarefa");
                },
            });
        }
    });
});
