CREATE DATABASE InfoUrban;
USE Infourban;

-- Primariamente temos os usuarios
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL, -- Armazene a senha criptografada
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Criamos a tabela cidades
CREATE TABLE cidades (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    estado CHAR(2) NOT NULL,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Depois criamos a tabela para armazenar as melhorias sugeridas
CREATE TABLE melhorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cidade_id INT NOT NULL,
    descricao TEXT NOT NULL,
    titulo TEXT NOT NULL,
    categoria VARCHAR(50),
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    relevancia INT DEFAULT 0,
    FOREIGN KEY (cidade_id) REFERENCES cidades(id) ON DELETE CASCADE
);

-- Apos as opiniões dos usuarios sobre as melhorias sugeridas dentro do InfoUrban
CREATE TABLE opinioes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    melhoria_id INT NOT NULL,
    usuario_id INT NOT NULL,
    opiniao TEXT NOT NULL,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (melhoria_id) REFERENCES melhorias(id) ON DELETE CASCADE,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- Cria a parte dos comentarios
CREATE TABLE comentarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    melhoria_id INT NOT NULL,
    usuario_id INT NOT NULL,
    comentario TEXT NOT NULL,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (melhoria_id) REFERENCES melhorias(id) ON DELETE CASCADE,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- Contabiliza os votos de relavancia quanto as melhorias sugeridas
CREATE TABLE votos_relevancia (
    id INT AUTO_INCREMENT PRIMARY KEY,
    melhoria_id INT NOT NULL,
    usuario_id INT NOT NULL,
    data_voto TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    estrelas INT NOT NULL,
    FOREIGN KEY (melhoria_id) REFERENCES melhorias(id) ON DELETE CASCADE,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    UNIQUE (melhoria_id, usuario_id)
);


-- Alguns INSERT's para testar a funcionalidade mais facilmente
INSERT INTO usuarios (nome, email, senha) VALUES
('João Silva', 'joao.silva@email.com', 'senha123'),
('Maria Oliveira', 'maria.oliveira@email.com', 'maria456'),
('Carlos Pereira', 'carlos.pereira@email.com', 'carlos789'),
('Ana Souza', 'ana.souza@email.com', 'ana1011'),
('Luís Costa', 'luis.costa@email.com', 'luis1213');
INSERT INTO cidades (nome, estado) VALUES
('São Paulo', 'SP'),
('Rio de Janeiro', 'RJ'),
('Belo Horizonte', 'MG'),
('Curitiba', 'PR'),
('Salvador', 'BA'),
('Porto Alegre', 'RS'),
('Recife', 'PE'),
('Fortaleza', 'CE'),
('Brasília', 'DF'),
('Manaus', 'AM');
INSERT INTO melhorias (titulo, descricao, categoria, relevancia, cidade_id, data_criacao) VALUES
('Melhoria no transporte público', 'A proposta é melhorar o transporte público na cidade, aumentando a frequência dos ônibus e criando novas linhas.', 'Infraestrutura', 4, 1, NOW()),
('Aumento de áreas verdes', 'Proposta de expansão de áreas verdes para promover mais qualidade de vida e lazer aos cidadãos.', 'Meio Ambiente', 5, 2, NOW()),
('Melhoria na segurança pública', 'Plano para aumentar a segurança nas principais ruas da cidade, com a instalação de mais câmeras de segurança.', 'Segurança', 3, 3, NOW());
INSERT INTO comentarios (comentario, melhoria_id, usuario_id, data_criacao) VALUES
('A melhoria no transporte público é essencial, a cidade está muito movimentada.', 1, 1, NOW()),
('Aumento de áreas verdes vai ajudar muito na qualidade de vida. Sou a favor!', 2, 2, NOW()),
('A segurança pública é uma prioridade, mas precisamos de mais ações concretas.', 3, 3, NOW());
INSERT INTO opinioes (opiniao, melhoria_id, usuario_id, data_criacao) VALUES
('A proposta do transporte público tem pontos positivos, mas precisa de mais detalhes.', 1, 1, NOW()),
('Área verde é fundamental, e expandir ela é uma excelente ideia.', 2, 2, NOW()),
('Eu apoio a proposta, mas sou contra mais câmeras de segurança, precisamos de mais policiamento.', 3, 3, NOW());
INSERT INTO votos_relevancia (estrelas, melhoria_id, usuario_id, data_voto) VALUES
(5, 1, 2, NOW()),
(3, 2, 3, NOW()),
(4, 3, 4, NOW());
