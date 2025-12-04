-- SQL convertido de MySQL para PostgreSQL (Supabase)

-- Estrutura para tabela `configuracoes`
CREATE TABLE configuracoes (
  id SERIAL PRIMARY KEY,
  chave VARCHAR(100) NOT NULL UNIQUE,
  valor TEXT NOT NULL
);

-- Despejando dados para a tabela `configuracoes`
INSERT INTO configuracoes (chave, valor) VALUES
('email', 'isabelamoscatelli@outlook.com'),
('telefone', '(11) 98349-6498'),
('localizacao', 'São Sebastião, SP, Brasil'),
('linkedin_url', 'https://www.linkedin.com/in/isabela-moscatelli-nogueira/'),
('instagram_url', 'https://www.instagram.com/isabelamoscatelli/');

-- Estrutura para tabela `experiencias`
CREATE TABLE experiencias (
  id SERIAL PRIMARY KEY,
  ano VARCHAR(50) NOT NULL,
  cargo VARCHAR(255) NOT NULL,
  empresa VARCHAR(255) NOT NULL,
  descricao TEXT NOT NULL,
  -- PostgreSQL não tem ENUM nativo como MySQL, usamos CHECK ou criamos um TYPE.
  -- Para simplificar, usaremos VARCHAR com CHECK.
  tipo VARCHAR(5) CHECK (tipo IN ('left', 'right')) DEFAULT 'left',
  ordem INTEGER DEFAULT 0
);

-- Despejando dados para a tabela `experiencias`
INSERT INTO experiencias (ano, cargo, empresa, descricao, tipo, ordem) VALUES
('2025 - Presente', 'Estágio em Analise e Desenvolvimento de Sistemas', 'Prefeitura Municipal de Caraguatatuba', 'Suporte à infraestrutura tecnológica, organizando os laboratórios de Informática e gerenciando os equipamentos nas escolas municipais.', 'left', 1),
('2021 - 2024', 'Analista de Desenvolvimento Sistemas Junior', 'Auto CredCar', 'Análise de requisitos, modelagem de sistemas e suporte à equipe de desenvolvimento de pesquisas veiculares.', 'right', 2),
('2020 - 2021', 'Assistente Administrativo', 'Auto CredCar', 'Organização e apoio do funcionamento do escritório.', 'left', 3);

-- Estrutura para tabela `habilidades`
CREATE TABLE habilidades (
  id SERIAL PRIMARY KEY,
  nome VARCHAR(100) NOT NULL,
  imagem VARCHAR(255) NOT NULL,
  ordem INTEGER DEFAULT 0
);

-- Despejando dados para a tabela `habilidades`
INSERT INTO habilidades (nome, imagem, ordem) VALUES
('HTML', 'html.png', 1),
('CSS', 'css.png', 2),
('Wordpress', 'wordpress.png', 3),
('PHP', 'php.png', 4);

-- Estrutura para tabela `portfolio`
CREATE TABLE portfolio (
  id SERIAL PRIMARY KEY,
  titulo VARCHAR(255) NOT NULL,
  descricao TEXT NOT NULL,
  imagem VARCHAR(255) NOT NULL,
  link VARCHAR(255) NOT NULL,
  -- TIMESTAMP com DEFAULT current_timestamp() é suportado, mas ON UPDATE não.
  -- Como o campo não é usado para UPDATE, a sintaxe é simplificada.
  data_criacao TIMESTAMP WITHOUT TIME ZONE NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Despejando dados para a tabela `portfolio`
INSERT INTO portfolio (titulo, descricao, imagem, link, data_criacao) VALUES
('Projeto Vamos Juntas', 'Site informativo do projeto "Vamos Juntas" um app de apoio para mulheres, que foi desenvolvido para o Projetor Integrador da FATEC - São Sebastião', 'vamos_juntas_logo.png', 'https://vamosjuntasprojeto.netlify.app/', '2025-11-30 23:38:58');

-- Estrutura para tabela `sobre`
CREATE TABLE sobre (
  id SERIAL PRIMARY KEY,
  titulo VARCHAR(255) NOT NULL,
  descricao TEXT NOT NULL,
  -- O ON UPDATE CURRENT_TIMESTAMP do MySQL não tem equivalente direto no PostgreSQL.
  -- Para manter a funcionalidade, o código PHP precisaria ser alterado para atualizar o campo manualmente.
  -- Por enquanto, vamos remover o ON UPDATE e manter apenas o DEFAULT.
  atualizado_em TIMESTAMP WITHOUT TIME ZONE NOT NULL DEFAULT CURRENT_TIMESTAMP,
  ordem INTEGER DEFAULT 0
);

-- Despejando dados para a tabela `sobre`
INSERT INTO sobre (titulo, descricao, atualizado_em, ordem) VALUES
('Sobre Mim', 'Sou estudante de Analise e Desenvolvimento de Sistemas.', '2025-12-01 01:07:36', 1),
('Descrição', 'Tenho paixão por tecnologia e por criar soluções que tragam impacto real. Possuo experiência em desenvolvimento de sistemas, análise de requisitos e participação em projetos que envolvem tanto a parte técnica quanto a colaboração em equipe. Estou sempre em busca de aprendizado contínuo e novos desafios, com o objetivo de entregar resultados de qualidade e contribuir para o crescimento das iniciativas das quais faço parte.', '2025-11-30 23:48:38', 2);

-- Fim do SQL para PostgreSQL
