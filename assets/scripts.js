function mostrarPlanilha(tipo, dadosUsuarios, dadosProdutos) {
    document.getElementById('minha-planilha').innerHTML = '';
    
    let config = {};

    if (tipo === 'usuarios') {
        config = {
            data: dadosUsuarios, 
            columns: [
                { title: 'Nome do Usuário', width: 300 },
                { title: 'Cargo', width: 150, type: 'dropdown', source: ['adm', 'usuario'] },
                { title: 'Status', width: 100, type: 'checkbox' },
            ]
        };
    } else {
        config = {
            data: dadosProdutos,
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

function previewImage() {
    // Pega o que o usuario digitou
    const url = document.getElementById('img_url').value.trim();
    // Pega o quadrado onde a imagem vai aparecer
    const container = document.getElementById('preview-container');
    // Pega o icone da camera para esconder ele
    const icone = document.getElementById('camera-icon');

    if (url) {
        // Aplica a imagem no fundo do container
        container.style.backgroundImage = "url('" + url + "')";
        // Esconde o icone cinza da camera
        icone.style.display = 'none';
    } else {
        // Se apagar a URL, volta ao estado original
        container.style.backgroundImage = 'none';
        icone.style.display = 'block';
    }
}



function mostrarPlanilha(tipo, dadosUsuarios, dadosProdutos) {
    let container = document.getElementById('minha-planilha');
    
    // Limpa o container antes de renderizar uma nova
    container.innerHTML = '';

    let colunas = [];
    let dadosParaExibir = [];

    if (tipo === 'usuarios') {
        dadosParaExibir = dadosUsuarios;
        colunas = [
            { title: 'Nome', width: 300 },
            { title: 'Tipo', width: 150 },
            { title: 'Ativo', width: 100, type: 'checkbox' }
        ];
    } else if (tipo === 'produtos') {
        dadosParaExibir = dadosProdutos;
        colunas = [
            { title: 'Livro', width: 350 },
            { title: 'Autor', width: 250 },
            { title: 'Preço (R$)', width: 100, type: 'number' }
        ];
    }

    // Inicializa o JSpreadsheet
    jspreadsheet(container, {
        data: dadosParaExibir,
        columns: colunas,
        minDimensions: [3, 10],
        tableOverflow: true,
        tableWidth: '100%',
    });
}