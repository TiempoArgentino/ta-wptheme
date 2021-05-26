var array = require('lodash/array');

(($) => {
    class AsyncSearch {
        constructor(id, settings = {}) {
            const {
                fetchURL = `${postSearch.homeurl}/wp-json/lr/v1/hemeroteca`,
            } = settings;
            this.id = id;
            this.filters = {
                tax_query: null,
            };
            this.initialize();
        }

        getTaxFilters() {
            return {};
        }

        fetchResults(preparationTime = 400) {
            const _this = this;
            const $results = $(`[data-asyncSearch="${this.id}"][data-results]`);
            const request = fetch(`${postSearch.homeurl}/wp-json/lr/v1/hemeroteca`, {
                method: 'POST',
                body: JSON.stringify(this.filters),
                headers: {
                    'Content-Type': 'application/json'
                }
            });
            request.then(function(response) {
                return response.json();
            })
            .then(function(newResults) {
                history.replaceState({
                    hemeroteca: _this.filters
                }, null)
                $results.find('.articles-list').html(newResults.html);
                $results.find('.pagination').html(newResults.pagination);
                endLoadingStatus(preparationTime);
            });
            return request;
        }

        initialize() {
            $(document).on('change', `[data-asyncSearch="${this.id}"][data-taxonomy]`, function(e) {
                const taxonomy = $(this).data('taxonomy');
                const $filtersInput = $(this).closest('.hemeroteca-tax-filters.general-input').find('input[name="tax-filters"]');
                const id = $(this).data('id').data('id');
                const isChecked = $(this).is(':checked');
                if (!this.filters[taxonomy]) {
                    this.filters[taxonomy] = {
                        taxonomy,
                        field: 'slug',
                        terms: [],
                    };
                }
                if (isChecked)
                    this.filters[taxonomy].terms.push(id);
                else
                    array.remove(this.filters[taxonomy].terms, id)

                $filtersInput.val(JSON.stringify(this.filters));
            })
        }
    }
})(jQuery)
