(function(undefined) {
    "use strict";

    /**
     * Sistema semelhante ao autocomplete, mas apenas para auxílio no preenchimento
     * de expressões no texto, não do conteúdo inteiro do campo.
     */
    $.sugestoesContatos = function(input, options) {
        var CLASS_SELECAO = "token-input-selected-dropdown-item-facebook";
        /** Número máximo de resultados que o servidor vai retornar */
        var MAX_RESULTADOS = 10;

        var sugestoes = {
            exibindo: false,
            prefixo:  undefined,
            /** Array de opções sendo exibida no momento */
            opcoes:   undefined,
            /** Índice da seleção atual */
            selecao:  undefined
        };
        /** Cache de consultas já realizadas */
        var cacheConsultas = {};

        var $input = $(input);
        var $divSugestoes;
        var $ulSugestoes;

        $input
            .keyup(verificarCampo)
            .mouseup(verificarCampo)
            .focus(verificarCampo)
            .blur(cancelarSugestoes)
            .keydown(function(e) {
                if (!sugestoes.exibindo || e.altKey || e.ctrlKey || e.metaKey || e.shiftKey) {
                    return;
                }

                var index = sugestoes.selecao;
                var numOpcoes = sugestoes.opcoes.length;

                switch (e.which) {
                    case 38: // seta p/ cima
                        selecionarOpcao(index == 0 ? numOpcoes - 1 : index - 1);
                        e.preventDefault();
                        break;
                    case 40: // seta p/ baixo
                        selecionarOpcao(index == numOpcoes - 1 ? 0 : index + 1);
                        e.preventDefault();
                        break;
                    case 36: // home
                        selecionarOpcao(0);
                        e.preventDefault();
                        break;
                    case 35: // end
                        selecionarOpcao(numOpcoes - 1);
                        e.preventDefault();
                        break;
                    case 13: // enter
                    case 9: // tab
                        confirmarOpcao(index)
                        e.preventDefault();
                        break;
                }
            });

        function verificarCampo() {
            var sel = $input.getSelection();
            if (sel.start != sel.end) {
                // usuário está fazendo uma seleção, não tratamos disso
                sugestoes.prefixo = undefined;
                cancelarSugestoes();
                return;
            }

            var texto = input.value.substring(0, sel.start);
            // verificar se o texto digitado termina com:
            //   início do texto ou caracter não-palavra, como espaço ou símbolo +
            //   arroba +
            //   1 a 80 caracteres válidos em url
            var match = texto.match(/(?:^|\W)@([\w\.\xc0-\xff]{1,80})$/);
            if (match) {
                carregarSugestoes(match[1].toLowerCase());
            } else {
                sugestoes.prefixo = undefined;
                cancelarSugestoes();
            }
        }

        function cancelarSugestoes() {
            if (sugestoes.exibindo) {
                sugestoes.exibindo = false;
                sugestoes.opcoes = undefined;
                sugestoes.selecao = undefined;
                $divSugestoes.hide();
            }
        }

        function carregarSugestoes(prefixo) {
            if (sugestoes.exibindo && sugestoes.prefixo == prefixo) {
                return;
            }

            sugestoes.prefixo = prefixo;

            if (apresentarSugestoesCache()) {
                return;
            }

            $.ajax({
                type: "GET",
                url: Routing.generate('CoreSearch_suggestion_listAutoComplete'),
                data: {
                    prefixo: prefixo,
                    returnType: "json"
                },
                dataType: "json",
                success: function(data) {
                    cacheConsultas[prefixo] = data;
                    if (sugestoes.prefixo) apresentarSugestoesCache();
                },
                error: function() {
                    // nenhum tratamento
                }
            });
        }

        function apresentarSugestoesCache() {
            var prefixo = sugestoes.prefixo;

            if (cacheConsultas.hasOwnProperty(prefixo)) {
                // usar cache e não consultar novamente
                apresentarSugestoes(cacheConsultas[prefixo], prefixo);
                return true;
            }

            // procurar por resultados parciais para usar como referência
            var parcial = procurarSugestoesParciais(prefixo);
            if (parcial) {
                apresentarSugestoes(parcial.lista, prefixo);
                if (parcial.total < MAX_RESULTADOS || parcial.lista.length >= MAX_RESULTADOS) {
                    // o total antes de filtrar já foi menor que o máximo
                    // -ou- não eliminamos nenhum resultado;
                    // não precisamos então fazer outra consulta ao servidor
                    return true;
                }
            } else {
                cancelarSugestoes();
            }
            return false;
        }

        function apresentarSugestoes(opcoes, destaque) {
            if (opcoes.length == 0) {
                cancelarSugestoes();
                return;
            }

            if (!$divSugestoes) {
                inicializarDivSugestoes();
            }

            $divSugestoes.show();
            sugestoes.exibindo = true;
            sugestoes.opcoes = opcoes;

            var fatorPosicao;
            var sel = $input.getSelection();
            var posTexto = sel.start - sugestoes.prefixo.length;
            if (posTexto < 15) {
                fatorPosicao = 0;
            } else if (posTexto < 30) {
                fatorPosicao = 0.25;
            } else {
                fatorPosicao = 0.5;
            }

            var offset = $input.offset();
            var left = offset.left + ($input.outerWidth() - $divSugestoes.outerWidth()) * fatorPosicao;
            // XXX usar .offset no jQuery 1.4+, não .css
            $divSugestoes.css({left: left, top: offset.top + $input.outerHeight()});

            $ulSugestoes.empty();
            $.each(opcoes, function(i, opcao) {
                var url = opcao.url;
                var item = $('<li class="token-input-dropdown-item2-facebook"/>').appendTo($ulSugestoes);

                $('<div class="contato_imagem"/>')
                    .append($('<img/>').attr("src", opcao.image).addClass('imgMedium'))
                    .appendTo(item);

                var eltInfo = $('<div class="contato_info"/>').appendTo(item);
                destacar(opcao.nome, destaque,
                    $('<div class="contato_nome"/>').appendTo(eltInfo));

            });
            selecionarOpcao(0);
        }

        function destacar(texto, destaque, pai) {
            var pos = match(texto, destaque);
            if (pos == -1) {
                pai.append(document.createTextNode(texto));
            } else {
                var end = pos + destaque.length;
                pai.append(document.createTextNode(texto.substring(0, pos)))
                pai.append($("<b/>").text(texto.substring(pos, end)))
                pai.append(document.createTextNode(texto.substring(end)));
            }
        }

        function inicializarDivSugestoes() {
            var id = "sugestoesContatos-" + (input.id || "") + "-" + Math.round(Math.random() * 1e9);
            $divSugestoes = $('<div class="j_sugestoesContatos token-input-dropdown-facebook"/>').attr("id", id).appendTo("body");
            $ulSugestoes = $('<ul/>').appendTo($divSugestoes);

            $("#" + id + " li")
                // XXX jQuery 1.3 não tem live mouseenter
                .live("mouseover", function() {
                    // XXX jQuery 1.3 não tem .index()
                    selecionarOpcao($(this).prevAll().length);
                })
                .live("mousedown", function() {
                    // XXX jQuery 1.3 não tem .index()
                    confirmarOpcao($(this).prevAll().length);
                    sugestoes.prefixo = undefined;
                    cancelarSugestoes();
                });
        }

        function selecionarOpcao(index) {
            var $children = $ulSugestoes.children();
            if (sugestoes.selecao !== undefined) {
                $children.removeClass(CLASS_SELECAO);
            }
            sugestoes.selecao = index;
            $children.eq(index).addClass(CLASS_SELECAO);
        }

        function confirmarOpcao(index) {
            input.focus();

            var sel = $input.getSelection();
            // se logo após o cursor houver um espaço, engolí-lo também
            if (input.value.substring(sel.end, sel.end + 1) == " ") {
                sel.end++;
            }
            // apagar prefixo atual...
            $input.deleteText(sel.start - sugestoes.prefixo.length, sel.end, true);
            // e inserir novo texto

            $input.replaceSelectedText(sugestoes.opcoes[index].nickname.replace(' ','') + " ");

            if ($('#'+input.id + '_hidden').length > 0) {
                var val = $('#'+input.id + '_hidden').val();
                $('#'+input.id + '_hidden').val(val+'|'+sugestoes.opcoes[index].coResult);
            } else {
                var $inputValue = $('<input type="hidden" id="'+input.id + '_hidden" />');
                $(input).append($inputValue);
                $inputValue.val(sugestoes.opcoes[index].coResult);
            }

            window.setTimeout(function() {
                input.focus();
            }, 10);
        }

        function procurarSugestoesParciais(prefixo) {
            for (var i = prefixo.length - 1; i > 0; i--) {
                var parte = prefixo.substring(0, i);
                if (cacheConsultas.hasOwnProperty(parte)) {

                    return {
                        total: cacheConsultas[parte].length,
                        lista: $.grep(cacheConsultas[parte], function(opcao) {
                            return match(opcao.url, prefixo) != -1
                                || match(opcao.nome, prefixo) != -1;
                        })
                    };
                }
            }
            return null;
        }
    };

    function match(texto, busca) {

        if (texto) {
            var textoLower = texto.toLowerCase();
            var buscaLower = busca.toLowerCase();
            if (textoLower.substring(0, busca.length) == buscaLower) {
                return 0;
            }
            var pos = textoLower.indexOf(" " + buscaLower);
            if (pos != -1) {
                return pos + 1;
            }
            return -1;
        }

        return 0;
    }

    $.fn.sugestoesContatos = function(options) {
        this.each(function() {
            $.sugestoesContatos(this, options);
        });
    };

})();

