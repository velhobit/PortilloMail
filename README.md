# PortilloMail
Sistema de Gerenciamento e Envio de EmailMarketing - Open Source
*versão alpha -> 0.3.2*

Muitas pessoas possuem a necessidade de enviar emails em lote, seja informativo ou publicitário. O problema é que há um custo alto para envio de emails ou possuem certas limitações, como contatos, quantidade de email. Além disso, a necessidade de cada mês pode variar, o que não justifica o valor fixo o custo por email, das empresas de mailmarketing.

Na prática, quem possui um servidor compartilhado, tem em média o direito de mandar entre 250 e 500 emails por hora. A maioria das empresas não possuem esse fluxo, principalmente fora do horário comercial. O objetivo deste projeto é usar esses envios ociosos e disperdiçados em emailmarketing ou informativo de forma gratuita, aberta e funcional.

## O que é o PortilloMail?
Desenvolvido em PHP, PortilloMail é um sistema de gerenciamento e envio de Emails.

Ele funciona definindo uma quantidade de emails por hora que você deseja enviar, usando o endereço de email de sua preferência para envio e resposta. O usuário é capaz de criar e gerenciar grupos, contatos, outros usuários eenviar emails. O sistema permite testes de email, reinicio do envio em casos de erros, edição de emails em rascunhos e acompanhamento de cliques, saber quantos e quem clicou no email.

**ATENÇÃO: EDITE O ARQUIVO enviar.php E enviar_teste.php para adicionar DKIM

**Este projeto foi feito por apenas uma pessoa, por tanto há diversos códigos denecessários, assim como ele pode e será otimizado e limpo com o passar do tempo. Esta é apenas uma ferramenta. Não nos responsabilizamos por seu uso, problemas, e materiais ilícitos que podem ser feito por terceiros. Muita atenção a licença usada neste projeto. Fique à vontade para moficiar o leiaute, mas por favor, mantenha a assinatura *Powered By*, mantendo o link.**

###Lista de Funcionalidades

- Escrever ou colar códigos HTML para envio de email
- Enviar email de teste
- Enviar emails automaticamente por hora
- Enviar emails por grupos
- Cadastro e gerenciamento dos grupos de destinatários
- Cadastro e gerenciamento individual de destinatário
- Cadastro e gerenciamento de usuários do sistema
- Uso de emails em outros servidores (SMTP) ou pelo servidor local (MAIL)
- Retomada de envio dos emails automáticos em caso de problemas
- Acompanhamento de quantas pessoas clicaram nos links dos emails e quem clicou
- Gera automaticamente página html com o email completo, para quem não consegegue visualizar
- Sistema automático de descadastramento, caso o usuário deseje descadastrar.
- Inclusão de Email diferente para resposta
- Registro do início e fim dos envios, assim como horário do último envio enviado
- É possível verificar se o processo foi interrompido (por reinicio ou outros problemas) e forçar continuação
- Ignora automaticamente emails repetidos
- Verifica se é realmente um email antes de enviar

###Funcionalidades Planejadas para Próximas Versões

- Registrar quantas pessoas visualizaram os emails
- Descrição de quantos emails já foram enviados e quantos faltam
- Exclusão automática de emails inexistentes da tabela de contato
- Reiniciar o processoa automaticamente, em caso de erro
- Envio de múltiplos grupos ao mesmo tempo
- Otimização de Design
- Otimização de Queries
- Limpeza de códigos inúteis
- Importação de Contatos direto pelo sistema
- Agendamento de processos através do servidor
- Ferramenta de Upload de Imagens
- Pré-visualização de Emails em Dispositivos Móveis
- Adaptabilidade para mobile e webapp
- Senha de envio criptografada
- Instalação Automática
- Documentação
- Para mais sugestões, envie email para rodrigo@portillodesign.com.br, com o assunto **PORTILLOMAIL**

#Instalação
Requerimentos: PHP 5.4 ou mais recente, MySQL. O sistema foi projetado para ser usado apenas em desktop.

1. Utilize o arquivo estrutura.sql para criar as tabelas
2. Copie os arquivos do projeto para dentro da pasta que deseja usar em seu servidor.
3. Configure o arquivo /libs/config.php. As instruções encontram-se dentro do próprio arquivo.
4. Será necessário cadastrar pelo menos um usuário diretamente no banco de dados. Use a senha em MD5 e o email do usuário será o email de envio. A senha do email de envio é diferente da senha do sistema. A senha do envio de email não está criptografada para facilitar a leitura, futuramente iremos criptogrofar essa senha também.

#Instruções de uso

Antes de enviar o email, vá na tela de grupos e contatos e os crie ou gerencie. Se preferir, importe os contatos diretamente no banco de dados. Lembre-se de cadastrar, em usuários, a senha do envio de email. Se ocorrer algum problema, coloque essa senha diretamente no banco de dados.

1. Vá no menu Novo Email
2. Escreva o assunto, escolha por qual email vai enviar e para qual grupo
2. Escreva o email ou adicione um HTML em Ferramentas>Código Fonte
3. Clique em Enviar
4. Na tela de Confirmação, verifique os dados. Se necessário volte.
5. Envie um email de teste para confirmar sua formatação e funcionamento.
6. Clique em Enviar e aguarde
7. Acompanhe o processo de envio através de Emails Enviados

#Faça uma doação!
Se você gostou do projeto, ajude este humilde desenvolvedor a atualiza-lo e trazer novas funções. Assim como trazer a vida outros projetos que estão em desenvolvimento.

###Para mais detalhes:
Acesse http://portillodesign.com.br/projeto-mail/ vídeos, explicações ilustrativas e doação

Curta a página da PortilloDesign no Facebook: https://www.facebook.com/PortilloDesign

Siga no Twitter e Instagram: @portillodesign

Para dúvidas, acesse o grupo Design de Interação, no Facebook: https://www.facebook.com/groups/interacao/
