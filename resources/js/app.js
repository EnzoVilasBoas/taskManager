import './bootstrap';
$(document).ready(function() {
            let currentPage = 1;

            // Função para carregar usuários
            function loadUsers(page = 1) {
                $.ajax({
                    url: `/dash/usuarios/list/${page}`,
                    method: 'GET',
                    success: function(response) {
                        const users = response.users;
                        const currentPage = response.current_page;
                        const lastPage = response.last_page;

                        // Limpar a lista atual
                        $('#user-list').empty();

                        // Adicionar usuários à tabela
                        users.forEach(user => {
                            $('#user-list').append(`
                                <tr>
                                    <td>${user.id}</td>
                                    <td>${user.name}</td>
                                    <td>${user.email}</td>
                                    <td>${user.stats}</td>
                                </tr>
                            `);
                        });

                        // Atualizar a paginação
                        let paginationHtml = '';
                        for (let i = 1; i <= lastPage; i++) {
                            paginationHtml += `
                                <li class="page-item ${i === currentPage ? 'active' : ''}">
                                    <a class="page-link" href="#" onclick="loadUsers(${i})">${i}</a>
                                </li>
                            `;
                        }
                        $('#pagination').html(`
                            <nav aria-label="Page navigation">
                                <ul class="pagination">
                                    ${paginationHtml}
                                </ul>
                            </nav>
                        `);
                    },
                    error: function() {
                        alert('Erro ao carregar os dados!');
                    }
                });
            }

            // Carregar a primeira página de usuários
            loadUsers(currentPage);
        });