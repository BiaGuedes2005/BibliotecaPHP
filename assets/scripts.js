/**
 * ARQUIVO CENTRAL DE SCRIPTS - BibliotecaPHP
 */

// 1. GERENCIAMENTO DA PLANILHA (JSpreadsheet) - Protegido contra erros de página
function mostrarPlanilha(tipo, dadosUsuarios, dadosProdutos) {
    let container = document.getElementById('minha-planilha');
    
    // Se o container não existir nesta página (ex: no index.php), para a execução antes de quebrar
    if (!container) return;

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

    // Inicializa o JSpreadsheet apenas se o elemento existir
    jspreadsheet(container, {
        data: dadosParaExibir,
        columns: colunas,
        minDimensions: [3, 10],
        tableOverflow: true,
        tableWidth: '100%',
    });
}

// 2. VERIFICAÇÃO DO TIPO DE USUÁRIO (Cadastro de Admin)
function verificarTipo() {
    const tipoCampo = document.getElementById('tipo');
    if (!tipoCampo) return; // Proteção

    const tipo = tipoCampo.value;
    const campoAdm = document.getElementById('campo_adm');
    const inputSenhaAdm = document.getElementById('senha_adm');

    if (campoAdm && inputSenhaAdm) {
        if (tipo === 'adm') {
            campoAdm.style.display = 'block';
            inputSenhaAdm.setAttribute('required', 'required');
        } else {
            campoAdm.style.display = 'none';
            inputSenhaAdm.removeAttribute('required');
        }
    }
}

// 3. PREVIEW DA IMAGEM DA CAPA DO LIVRO
function previewImage() {
    const urlCampo = document.getElementById('img_url');
    if (!urlCampo) return; // Proteção

    const url = urlCampo.value.trim();
    const container = document.getElementById('preview-container');
    const icone = document.getElementById('camera-icon');

    if (container && icone) {
        if (url) {
            container.style.backgroundImage = "url('" + url + "')";
            icone.style.display = 'none';
        } else {
            container.style.backgroundImage = 'none';
            icone.style.display = 'block';
        }
    }
}

// 4. ALTERNAR TEMA (Claro / Escuro)
function alternarTema() {
    const temaAtual = document.body.classList.contains('dark') ? 'escuro' : 'claro';
    const novoTema = temaAtual === 'escuro' ? 'claro' : 'escuro';

    fetch('pages/salvar_tema.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'tema=' + novoTema
    }).then(() => {
        document.body.classList.toggle('dark');
        const icone = document.getElementById('icone-tema');
        if (icone) {
            icone.classList.toggle('fa-moon');
            icone.classList.toggle('fa-sun');
        }
    });
}

// 5. BANNER DE COOKIES (Aviso de Feedback)
function fecharBannerNaTela(event) {
    const urlAlvo = event.currentTarget.getAttribute('href');
    
    if (urlAlvo.includes('sim')) {
        alert("Obrigado por aceitar! O PHP salvou seu cookie por 30 dias.");
    } else {
        alert("Você recusou. O PHP guardou sua escolha apenas para esta sessão.");
    }
}