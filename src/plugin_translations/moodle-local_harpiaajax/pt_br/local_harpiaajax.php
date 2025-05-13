<?php
// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Strings for 'local_harpiaajax' in Brazilian Portuguese.
 *
 * @package    local_harpiaajax
 * @copyright  2025 C4AI-USP <c4ai@usp.br>
 * @author     Vinícius B. Matos
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

 $string['pluginname'] = "HarpIA AJAX";
 $string['noaccess'] = "Você não pode realizar esta operação.";

 $string['answer_providers'] = "Fornecedores de respostas";
 $string['add_answer_provider'] = "Adicionar";
 $string['api_type'] = "Tipo de API";
 $string['name'] = "Nome";
 $string['api_key'] = "Chave da API";
 $string['model'] = "Modelo";
 $string['base_url'] = "URL base";
 $string['openai_chat_completions_api_base_url'] = "URL base";
 $string['openai_chat_completions_api_base_url_help'] = "Exemplo: https://api.openai.com/v1/chat/completions";
 $string['openai_chat_completions_api_base_url_error'] = "Deve terminar com \"chat/completions\".";
 $string['default_system_prompt'] = "Prompt de sistema padrão";
 $string['extra_request_fields'] = "Campos extras da requisição (JSON)";
 $string['openai_chat_completions_api_extra_request_fields_help'] = "Exemplo: {\"max_tokens\": 128, \"temperature\": 0.7}";
 $string['trivial_extra_request_fields_help'] = "Exemplo (para o modelo \"constant\"): {\"value\": \"Sempre responderei com este texto\"}";

 $string['adding_answer_providers'] = "Adicionando fornecedor de respostas";
 $string['bad_json'] = "JSON inválido";
 $string['no_answer_providers'] = "Nenhum fornecedor de respostas deste tipo foi adicionado.";
 $string['model_not_found'] = 'Modelo "$a" não encontrado.';
 $string['model_not_found_list'] = 'Modelo "{$a->model}" não encontrado. Escolha um dos seguintes: {$a->models}.';
 $string['failed_to_generate_answer'] = 'Houve uma falha ao tentar gerar uma resposta.';
 $string['answer_provider_not_found'] = 'Fornecedor de respostas não encontrado.';

 $string['test'] = 'Testar';
 $string['query'] = 'Consulta';
 $string['answer'] = 'Resposta';
 $string['send'] = 'Enviar mensagem de teste';
 $string['back_to_list'] = 'Voltar para a lista';
 $string['enabled'] = "Habilitado";

 $string['gateway_type'] = 'Tipo de gateway';
 $string['internal'] = 'Interno';
 $string['external'] = 'Externo';
 $string['external_gateway_address'] = 'Endereço do gateway externo';
 $string['system_prompt_unsupported'] = '(não suportado)';

 $string['openai_chat_completions_api'] = "API OpenAI Chat Completions";
 $string['trivial'] = "Trivial";
