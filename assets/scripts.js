// Este código vai no arquivo .js
// O arquivo .js fica limpo, apenas com a lógica
function mostrarPlanilha(tipo, dadosUsuarios, dadosProdutos) {
    document.getElementById('minha-planilha').innerHTML = '';
    
    let config = {};

    if (tipo === 'usuarios') {
        config = {
            data: dadosUsuarios, // Usa o dado que veio por parâmetro
            columns: [
                { title: 'Nome do Usuário', width: 300 },
                { title: 'Cargo', width: 150, type: 'dropdown', source: ['adm', 'usuario'] },
                { title: 'Status', width: 100, type: 'checkbox' },
            ]
        };
    } else {
        config = {
            data: dadosProdutos, // Usa o dado que veio por parâmetro
            columns: [
                { title: 'Livro', width: 300 },
                { title: 'Autor', width: 200 },
                { title: 'Preço (R$)', width: 150, type: 'numeric', mask: 'R$ #.##0,00' },
            ]
        };
    }

    planilha = jspreadsheet(document.getElementById('minha-planilha'), config);
}
    


function verificarTipo() {
    const tipo = document.getElementById('tipo').value;
            const campoAdm = document.getElementById('campo_adm');
            const inputSenhaAdm = document.getElementById('senha_adm');

            if (tipo === 'adm') {
                campoAdm.style.display = 'block';
                inputSenhaAdm.setAttribute('required', 'required');
            } else {
                campoAdm.style.display = 'none';
                inputSenhaAdm.removeAttribute('required');
            }
}