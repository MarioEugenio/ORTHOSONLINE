(function($, undefined) {
"use strict";

var debugSuffix = "";

/**
 * Funções para facilitar uso das rotas single-page no cliente.
 *
 * É possível detectar mudanças na rota ouvindo os seguintes eventos em `document`:
 *
 * - SinglePage.changeStart: quando uma mudança de URL é detectada e uma nova página é carregada
 * - SinglePage.changeSuccess: quando a nova página é carregada e inicializada
 * - SinglePage.changeError: quando ocorre um erro no carregamento da nova página
 * - SinglePage.hashChanged: quando o sub-hash da página altera mantendo o mesmo caminho
 *
 * @type {Object}
 */
window.SinglePage = {
    _currentLocation: undefined,
    _beforeRenderHandlers: [],
    _afterRenderHandlers: [],
    /**
     * Pai dos containers de renderização.
     * @type {jQuery}
     */
    _contentArea: undefined,
    /**
     * Container sendo exibido no momento.
     * @type {jQuery}
     */
    _currentContainer: undefined,

    /**
     * Retorna o caminho relativo para a rota dada.
     * @param {string} routeName Nome da rota
     * @param {Object} [params] Parâmetros para a rota
     * @return {string} "#/foo/bar"
     */
    pathFor: function(routeName, params) {
        if (routeName === "Home" && !params) {
            return "#/";
        }

        var path = Routing.generate(routeName, params).substring(Routing.getBaseUrl().length);
        if (path.substring(0, 1) != "/") {
            path = "/" + path;
        }
        return "#" + path;
    },

    /**
     * Retorna a URL completa para a rota dada.
     * @param {string} routeName Nome da rota
     * @param {Object} [params] Parâmetros para a rota
     * @return {string} "http://example.com/#/foo/bar"
     */
    urlFor: function(routeName, params) {
        return location.protocol + "//" + location.host + Routing.generate("Home") + this.pathFor(routeName, params);
    },

    /**
     * Retorna dados sobre a URL no browser.
     * @return {Object} {path: string, hash: string?}
     */
    getLocation: function() {
        var fullPath = location.hash.substring(1);
        var hashPos = fullPath.indexOf("#");

        var path = hashPos === -1 ? fullPath : fullPath.substring(0, hashPos);
        var hash = hashPos === -1 ? undefined : fullPath.substring(hashPos + 1);
        return {path: path, hash: hash};
    },

    /**
     * Retorna o caminho escrito na URL do browser (sem sub-hash).
     * @return {string}
     */
    getPath: function() {
        return this.getLocation().path;
    },

    /**
     * Retorna a sub-hash da URL do browser, ou `undefined` se não houver uma.
     * @return {string?}
     */
    getHash: function() {
        return this.getLocation().hash;
    },

    /**
     * Altera o sub-hash da página atual.
     * @param {?string|Object} hash
     * @param {boolean} [replace]
     */
    setHash: function(hash, replace) {
        if (hash instanceof Object) {
            hash = $.param(hash);
        }
        var target = this._currentLocation.path;
        if (hash) {
            target += "#" + hash;
        }
        if (replace) {
            location.replace("#" + target);
        } else {
            location.hash = target;
        }
    },

    /**
     * Redireciona a aplicação para a página apontada pela rota dada.
     * Se a rota dada for a mesma da página atual, o conteúdo é recarregado.
     * @param {string} routeName Nome da rota
     * @param {Object} [params] Parâmetros para a rota
     */
    goTo: function(routeName, params) {
        var newPath = this.pathFor(routeName, params);
        if (location.hash === newPath) {
            // forçar recarga
            this.reload();
        } else {
            location.hash = newPath;
        }
    },

    /**
     * Força que a página atual seja recarregada.
     */
    reload: function() {
        this._load(this.getPath());
    },

    /**
     * Retorna a URL que deve ser carregada como página inicial.
     * @return {string}
     */
    getHomeURL: function() {
        return Routing.generate($("meta[name=homeRoute]").attr("content"));
    },

    /**
     * Inicialização do sistema de rotas.
     * @private
     */
    _init: function() {
        if ($("meta[name='kernel.debug']").attr("content") === "true") {
            debugSuffix = "?" + (+new Date());
        }
        this.onHashChange();
        $(window).hashchange($.proxy(this, "onHashChange"));
        this._contentArea = $("#content");
    },

    /**
     * Invocado quando o hash da URL é alterado.
     */
    onHashChange: function() {
        var path = location.hash;
        if (path === "" || path === "#") {
            path = "#/";
            location.replace(path);
        }

        if (path.substring(0, 2) !== "#/") {
            // TODO tratamento mais apropriado
            console.error("ERRO!", path);
            return;
        }

        var newLocation = this.getLocation();

        if (!this._currentLocation || newLocation.path !== this._currentLocation.path) {
            this._currentLocation = newLocation;
            this._load(newLocation.path);
        } else if (newLocation.hash !== this._currentLocation.hash) {
            this._currentLocation = newLocation;
            $(document).trigger("SinglePage.hashChange", newLocation.hash);
        }
    },

    /**
     * Carrega a página referente ao caminho dado, invocando os eventos apropriados.
     * @param {string} path Caminho a ser carregado (sem "#")
     * @private
     */
    _load: function(path) {
        if (this._request) {
            this._request.abort();
        }

        this._onChangeStart(path);

        try {
            var url;
            if (path == "/") {
                url = this.getHomeURL();
            } else {
                url = Routing.getBaseUrl() + path;
            }

            this._request = $.ajax(url)
                .done($.proxy(function(result) {
                    this._render(result)
                        .done($.proxy(function() {
                            this._onChangeSuccess(path);
                        }, this))
                        .fail($.proxy(function() {
                            this._onChangeError(path);
                        }, this));
                }, this))
                .fail($.proxy(function(xhr, statusText) {
                    this._onChangeError(path, statusText, xhr);
                }, this));
        } catch (exception) {
            console.error(exception.message, exception);
            this._onChangeError(path, "exception", null);
        }
    },

    /**
     * Adiciona uma função a ser invocada antes do conteúdo da página ser trocado.
     * @param {Function($content)} fn Função a ser invocada
     */
    beforeRender: function(fn) {
        this._beforeRenderHandlers.push(fn);
    },

    /**
     * Adiciona uma função a ser invocada após o conteúdo da página ser trocado.
     * @param {Function($content)} fn Função a ser invocada
     */
    afterRender: function(fn) {
        this._afterRenderHandlers.push(fn);
    },

    _freeCurrentContainer: function() {
        if (this._currentContainer) {
            $.each(this._beforeRenderHandlers, function(i, handler) {
                handler(this._currentContainer);
            });
            this._currentContainer.remove().empty();
            this._currentContainer = null;
        }
    },

    /**
     * Carrega o HTML dado na área de conteúdo.
     * @param {string} html HTML a ser usado como conteúdo
     * @return {Promise}
     * @private
     */
    _render: function(html) {
        var $content = $('<div/>').hide().appendTo(this._contentArea);

        $.holdReady(true);
        // se o novo código tiver tags <script> embutidas, eliminar o container atual
        // antecipadamente, pois os scripts que serão executados imediatamente podem
        // tentar acessar algum item por ID ou classe que já estão presentes no conteúdo antigo
        if (html.match(/<script/i)) {
            this._freeCurrentContainer();
        }
        $content.html(html);

        var promise = this.loadDeferredScripts($content);

        promise.then($.proxy(function() {
            if (this._currentContainer !== $content) {
                this._freeCurrentContainer();
            }
            this._currentContainer = $content;
            $.holdReady(false);
            $.each(this._afterRenderHandlers, function(i, handler) {
                handler($content);
            });
            $content.show();
        }, this));

        return promise;
    },

    /**
     * Carrega scripts declarados via .j-deferScript.
     * @param {jQuery} $content Área que deve ser processada
     * @return {Promise}
     */
    loadDeferredScripts: function($content) {
        var deferred = $.Deferred();

        var deferScripts = $content.find(".j-deferScript");
        if (deferScripts.length) {
            var scripts = deferScripts.map(function() {
                return $(this).data("src") + debugSuffix;
            }).get();
            $script(scripts, function() {
                deferred.resolve();
            });
        } else {
            deferred.resolve();
        }

        return deferred.promise();
    },

    /**
     * Invocado quando se está iniciando a navegação para um novo endereço.
     * @param {string} path Caminho a ser carregado
     * @private
     */
    _onChangeStart: function(path) {
        Loading.showAll();
        $(document).trigger("SinglePage.changeStart", path);
    },

    /**
     * Invocado quando a carga de uma nova página é finalizada com sucesso.
     * @param {string} path Caminho carregado
     * @private
     */
    _onChangeSuccess: function(path) {
        Loading.hideAll();
        $(document).trigger("SinglePage.changeSuccess", path);
    },

    /**
     * Invocado quando não é possível carregar um endereço.
     * @param {string} path Caminho que se tentou carregar
     * @param {string} statusText Status retornado pelo jQuery XHR
     * @param {?jqXHR} xhr Objeto XHR que originou o erro, se apropriado
     * @private
     */
    _onChangeError: function(path, statusText, xhr) {
        Loading.hideAll();
        if (statusText === "abort") {
            // solicitações abortadas não são erros; estão apenas sendo trocadas por outra
            // página (por exemplo, o usuário clicou no botão Voltar do browser duas vezes)
            return;
        }
        if (xhr.status == 418) {
            // falha de autenticação; tratada pelo módulo AuthCheck
            return;
        }
        if (xhr && xhr.responseText) {
            this._render(xhr.responseText);
        }
        console.log("ROUTE CHANGE ERROR", arguments);
        $(document).trigger("SinglePage.changeError", path);
    }
};


})(jQuery);
