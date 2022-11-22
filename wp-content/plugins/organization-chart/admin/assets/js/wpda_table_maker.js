function wpdaTableMaker(table_id = '') {
    if (typeof (window.wpdaPageRowsList) == 'undefined') {
        alert('Can\'t get Rows info please contact plugin authors');
        return;
    }
    this.initialed = false;
    this.listObjectModel = {};
    this.itemCount = window.wpdaPageRowsList.length;
    this.pageItemCount = 20;
    this.originalRowsList = window.wpdaPageRowsList;
    this.filteredRowsList = this.originalRowsList;
    this.pageRowsInfo = window.wpdaPageRowsInfo;
    this.listObjectModel['main'] = document.getElementById(table_id);
    this.createNavigationHtml();
    this.createTableHtml();
    this.createTableHead();
    this.initialValues();
    this.filter();
    this.ordering();
    this.setOrderingCss();
    this.updatePagination();
    this.createTableBody();
    this.addEvents();
    this.initialed = true;
}

wpdaTableMaker.prototype.ordering = function () {
    if (!Array.isArray(this.filteredRowsList) || this.filteredRowsList.length < 1) {
        return;
    }
    let orderBy = window.localStorage.getItem(this.pageRowsInfo['link_page'] + '_order_by');
    let order = window.localStorage.getItem(this.pageRowsInfo['link_page'] + '_order');
    let orderType = this.getOrderType(orderBy);
    if (orderBy == null || order == null) {
        return;
    }
    if (orderType == 'number') {
        this.filteredRowsList.sort(function (el1, el2) {
            let returnValue = 0;
            if (parseInt(el1[orderBy]) > parseInt(el2[orderBy])) {
                returnValue = 1;
            }
            if (parseInt(el1[orderBy]) < parseInt(el2[orderBy])) {
                returnValue = -1;
            }
            if (order == 'asc') {
                return returnValue;
            }
            return -1 * returnValue;
        });
    } else {
        this.filteredRowsList.sort(function (el1, el2) {
            let returnValue = 0;
            if (el1[orderBy].toLowerCase() > el2[orderBy].toLowerCase()) {
                returnValue = 1;
            }
            if (el1[orderBy].toLowerCase() < el2[orderBy].toLowerCase()) {
                returnValue = -1;
            }
            if (order == 'asc') {
                return returnValue;
            }
            return -1 * returnValue;
        });
    }
}

wpdaTableMaker.prototype.filter = function () {
    if (!Array.isArray(this.originalRowsList) || this.originalRowsList.length < 1) {
        return;
    }
    this.filteredRowsList = this.originalRowsList.filter(function (row) {
        for (key in row) {
            if ((row[key] + '').toLowerCase().indexOf(this.listObjectModel['searchInput'].value.toLowerCase()) !== -1) {
                return true;
            }
        }
        return false;
    }.bind(this));
    this.itemCount = this.filteredRowsList.length;
    this.updatePagination(true);
}

wpdaTableMaker.prototype.createTableHtml = function () {
    this.listObjectModel['table'] = this.createHtmlElement('table', { 'class': 'wp-list-table widefat fixed pages' });
    this.listObjectModel['thead'] = this.createHtmlElement('thead', { 'class': 'tablenav top' });
    this.listObjectModel['tbody'] = this.createHtmlElement('tbody', { 'class': 'tablenav top' });
    this.listObjectModel['table'].appendChild(this.listObjectModel['thead']);
    this.listObjectModel['table'].appendChild(this.listObjectModel['tbody']);
    this.listObjectModel['main'].appendChild(this.listObjectModel['table']);
}

wpdaTableMaker.prototype.createTableHead = function () {
    let locHTML = {};
    this.listObjectModel['link'] = new Array();
    locHTML['tr'] = this.createHtmlElement('tr');
    for (key in this.pageRowsInfo['keys']) {
        if (this.pageRowsInfo['keys'][key].hasOwnProperty('sortable')) {
            var th = this.createHtmlElement('th', { 'class': 'manage-column sortable desc' });
            let a = this.createHtmlElement('a', { 'date-key': key });
            this.listObjectModel['link'].push(a);
            let spanName = this.createHtmlElement('span', {}, this.pageRowsInfo['keys'][key]['name']);
            let spanIndicator = this.createHtmlElement('span', { 'class': 'sorting-indicator' });
            th.appendChild(a);
            a.appendChild(spanName)
            a.appendChild(spanIndicator);
        } else {
            var th = this.createHtmlElement('th', { 'class': 'wpda-column-small' }, this.pageRowsInfo['keys'][key]['name']);
        }
        locHTML['tr'].appendChild(th);
        this.listObjectModel['thead'].appendChild(locHTML['tr']);
    }
}

wpdaTableMaker.prototype.createTableBody = function () {
    this.listObjectModel['tbody'].innerHTML = '';
    let currentPage = window.localStorage.getItem(this.pageRowsInfo['link_page'] + '_current_page') || 1;
    if (this.itemCount > 0) {
        for (let i = (Math.max(0, (currentPage - 1))) * this.pageItemCount; i < Math.min(currentPage * this.pageItemCount, this.itemCount); i++) {
            let tr = this.createHtmlElement('tr');
            for (key in this.pageRowsInfo['keys']) {
                var td = this.createHtmlElement('td');
                let name = this.pageRowsInfo['keys'][key]['name'];
                if (this.filteredRowsList[i].hasOwnProperty(key)) {
                    name = this.filteredRowsList[i][key];
                    if(typeof(this.pageRowsInfo['keys'][key]['replace_value']) !== 'undefined' && typeof(this.pageRowsInfo['keys'][key]['replace_value'][name]) !== 'undefined'){
                        name = this.pageRowsInfo['keys'][key]['replace_value'][name];
                    }
                }
                if (this.pageRowsInfo['keys'][key].hasOwnProperty('link')) {
                    var child = this.createHtmlElement('a', { 'href': 'admin.php?page=' + this.pageRowsInfo['link_page'] + this.pageRowsInfo['keys'][key]['link'] + '&id=' + this.filteredRowsList[i]['id'] }, name);
                } else {
                    var child = this.createHtmlElement('span', {}, name);
                }
                td.appendChild(child);
                tr.appendChild(td);
            }
            this.listObjectModel['tbody'].appendChild(tr);
        }
    }
}

wpdaTableMaker.prototype.createNavigationHtml = function () {
    let locHTML = {};
    locHTML['main'] = this.createHtmlElement('div', { 'class': 'tablenav top' });
    this.listObjectModel['searchInput'] = locHTML['search'] = this.createHtmlElement('input', { 'type': 'text', 'placeholder': 'Search', 'class': 'wpda_search' });
    this.listObjectModel['navContainer'] = locHTML['navContainer'] = this.createHtmlElement('div', { 'class': 'tablenav-pages' });
    this.listObjectModel['navRowsCount'] = locHTML['navRowsCount'] = this.createHtmlElement('span', { 'class': 'pageCount' }, this.getItemCountText());
    this.listObjectModel['paginationContainer'] = locHTML['paginationContainer'] = this.createHtmlElement('span', { 'class': 'tablenav top' });
    locHTML['paginationLinksContainer'] = this.createHtmlElement('span', { 'class': 'pagination-links' });
    this.listObjectModel['paginationFirstPageLink'] = locHTML['paginationFirstPageLink'] = this.createHtmlElement('a', { 'class': 'tablenav-pages-navspan button', 'title': 'Go to the first page' }, '«');
    this.listObjectModel['paginationPreviousPageLink'] = locHTML['paginationPreviousPageLink'] = this.createHtmlElement('a', { 'class': 'tablenav-pages-navspan button', 'title': 'Go to the previous page' }, '‹');
    locHTML['paginationPositionContainer'] = this.createHtmlElement('span', { 'class': 'tablenav top' }, '');
    this.listObjectModel['paginationPositionContainerCurrent'] = locHTML['paginationPositionContainerCurrent'] = this.createHtmlElement('input', { 'type': 'text', 'class': 'current-page wpda-current-page', 'value': '1', 'size': '1' });
    this.listObjectModel['paginationPositionContainerCount'] = locHTML['paginationPositionContainerCount'] = this.createHtmlElement('span', {}, ' of ' + Math.ceil(this.itemCount / this.pageItemCount));
    this.listObjectModel['paginationNextPageLink'] = locHTML['paginationNextPageLink'] = this.createHtmlElement('a', { 'class': 'tablenav-pages-navspan button', 'title': 'Go to the next page' }, '›');
    this.listObjectModel['paginationLastPageLink'] = locHTML['paginationLastPageLink'] = this.createHtmlElement('a', { 'class': 'tablenav-pages-navspan button', 'title': 'Go to the last page' }, '»');
    // connect elements together
    locHTML['main'].appendChild(locHTML['search']);
    locHTML['main'].appendChild(locHTML['navContainer']);
    locHTML['navContainer'].appendChild(locHTML['navRowsCount']);
    locHTML['navContainer'].appendChild(locHTML['paginationContainer']);
    locHTML['paginationContainer'].appendChild(locHTML['paginationLinksContainer']);
    locHTML['paginationLinksContainer'].appendChild(locHTML['paginationFirstPageLink']);
    locHTML['paginationLinksContainer'].appendChild(locHTML['paginationPreviousPageLink']);
    locHTML['paginationLinksContainer'].appendChild(locHTML['paginationPositionContainer']);
    locHTML['paginationPositionContainer'].appendChild(locHTML['paginationPositionContainerCurrent']);
    locHTML['paginationPositionContainer'].appendChild(locHTML['paginationPositionContainerCount']);
    locHTML['paginationLinksContainer'].appendChild(locHTML['paginationNextPageLink']);
    locHTML['paginationLinksContainer'].appendChild(locHTML['paginationLastPageLink']);
    this.listObjectModel['main'].appendChild(locHTML['main']);
}

wpdaTableMaker.prototype.addEvents = function () {
    let self = this;
    this.listObjectModel['searchInput'].addEventListener('input', function () {
        window.localStorage.setItem(self.pageRowsInfo['link_page'] + '_filter', this.value);
        self.filter();
        self.createTableBody();
    });
    // add ordering functionality
    for (let i = 0; i < this.listObjectModel['link'].length; i++) {
        this.listObjectModel['link'][i].addEventListener('click', function () {
            if (self.pageRowsInfo['keys'].hasOwnProperty(this.getAttribute('date-key'))) {
                self.resetOrderingCss();
                let previousOrderBy = window.localStorage.getItem(self.pageRowsInfo['link_page'] + '_order_by');
                let order = window.localStorage.getItem(self.pageRowsInfo['link_page'] + '_order');
                if (order === null || order === 'desc' || previousOrderBy != this.getAttribute('date-key')) {
                    window.localStorage.setItem(self.pageRowsInfo['link_page'] + '_order', 'asc');
                } else {
                    window.localStorage.setItem(self.pageRowsInfo['link_page'] + '_order', 'desc');
                }
                window.localStorage.setItem(self.pageRowsInfo['link_page'] + '_order_by', this.getAttribute('date-key'));
            }
            self.ordering();
            self.setOrderingCss();
            self.createTableBody();
        })
    }
    // add pagination functionality    
    this.listObjectModel['paginationFirstPageLink'].addEventListener('click', function () {
        window.localStorage.setItem(self.pageRowsInfo['link_page'] + '_current_page', '1');
        self.updatePagination();
        self.createTableBody();
    })
    this.listObjectModel['paginationPreviousPageLink'].addEventListener('click', function () {
        let currentPage = window.localStorage.getItem(self.pageRowsInfo['link_page'] + '_current_page');
        window.localStorage.setItem(self.pageRowsInfo['link_page'] + '_current_page', Math.max(1, (parseInt(currentPage) - 1)));
        self.updatePagination();
        self.createTableBody();
    })
    this.listObjectModel['paginationPositionContainerCurrent'].addEventListener('change', function () {
        let maxPageCount = Math.ceil(self.itemCount / self.pageItemCount);
        let value = Math.min(maxPageCount, parseInt(this.value));
        if (isNaN(value)) {
            value = 1;
        }
        let currentPage = Math.max(1, value);
        window.localStorage.setItem(self.pageRowsInfo['link_page'] + '_current_page', currentPage);
        self.updatePagination();
        self.createTableBody();
    })
    this.listObjectModel['paginationNextPageLink'].addEventListener('click', function () {
        let maxPageCount = Math.ceil(self.itemCount / self.pageItemCount);
        let currentPage = window.localStorage.getItem(self.pageRowsInfo['link_page'] + '_current_page');
        window.localStorage.setItem(self.pageRowsInfo['link_page'] + '_current_page', '' + Math.min(maxPageCount, (parseInt(currentPage) + 1)));
        self.updatePagination();
        self.createTableBody();
    })
    this.listObjectModel['paginationLastPageLink'].addEventListener('click', function () {
        let maxPageCount = Math.ceil(self.itemCount / self.pageItemCount);
        window.localStorage.setItem(self.pageRowsInfo['link_page'] + '_current_page', maxPageCount);
        self.updatePagination();
        self.createTableBody();
    })
}

wpdaTableMaker.prototype.getItemCountText = function () {
    switch (parseInt(this.itemCount)) {
        case 0:
            return 'no items';
            break;
        case 1:
            return '1 item';
            break;
        default:
            return parseInt(this.itemCount) + ' items';
    }
}

wpdaTableMaker.prototype.createHtmlElement = function (tag = "", attr = {}, innerHTML = "") {
    let el = document.createElement(tag);
    for (const key in attr) {
        el.setAttribute(key, attr[key]);
    }
    if (innerHTML != '') {
        el.innerHTML = innerHTML;
    }
    return el;
}

wpdaTableMaker.prototype.resetOrderingCss = function () {
    let sortableColumns = this.listObjectModel['thead'].children[0].getElementsByClassName('manage-column');
    let length = sortableColumns.length;
    for (let i = 0; i < length; i++) {
        sortableColumns[i].setAttribute('class', 'manage-column sortable desc');
    }
}

wpdaTableMaker.prototype.setOrderingCss = function () {
    let sortableColumns = this.listObjectModel['thead'].children[0].getElementsByClassName('manage-column');
    let length = sortableColumns.length;
    let orderBy = window.localStorage.getItem(this.pageRowsInfo['link_page'] + '_order_by');
    let order = window.localStorage.getItem(this.pageRowsInfo['link_page'] + '_order');
    for (let i = 0; i < length; i++) {
        if (sortableColumns[i].getElementsByTagName('a')[0].getAttribute('date-key') == orderBy) {
            sortableColumns[i].setAttribute('class', 'manage-column sorted ' + order);
            break;
        }
    }
}

wpdaTableMaker.prototype.updatePagination = function (reset = false) {
    let currentPage = window.localStorage.getItem(this.pageRowsInfo['link_page'] + '_current_page') || 1;
    let maxPageCount = Math.ceil(this.itemCount / this.pageItemCount);
    if (reset && this.initialed) {
        currentPage = 1;
        window.localStorage.setItem(this.pageRowsInfo['link_page'] + '_current_page', '1');
    }
    this.listObjectModel['paginationPositionContainerCount'].innerHTML = ' of ' + maxPageCount;
    this.listObjectModel['navRowsCount'].innerHTML = this.getItemCountText();
    this.listObjectModel['paginationContainer'].style.display = 'inline';
    this.listObjectModel['paginationFirstPageLink'].classList.remove('disabled')
    this.listObjectModel['paginationPreviousPageLink'].classList.remove('disabled')
    this.listObjectModel['paginationNextPageLink'].classList.remove('disabled')
    this.listObjectModel['paginationLastPageLink'].classList.remove('disabled')
    if (maxPageCount <= 1) {
        this.listObjectModel['paginationContainer'].style.display = 'none';
    }
    if (currentPage == 1) {
        this.listObjectModel['paginationFirstPageLink'].classList.add('disabled')
        this.listObjectModel['paginationPreviousPageLink'].classList.add('disabled')
    }
    if (currentPage == maxPageCount) {
        this.listObjectModel['paginationNextPageLink'].classList.add('disabled')
        this.listObjectModel['paginationLastPageLink'].classList.add('disabled')
    }

    this.listObjectModel['paginationPositionContainerCurrent'].value = currentPage;
}

wpdaTableMaker.prototype.getOrderType = function (orderBy) {
    let length = this.filteredRowsList.length;
    for (let i = 0; i < length; i++) {
        if (isNaN(this.filteredRowsList[i][orderBy])) {
            return 'string';
        }
    }
    return 'number';
}

wpdaTableMaker.prototype.initialValues = function () {
    let valueFilter = window.localStorage.getItem(this.pageRowsInfo['link_page'] + '_filter') || '';
    this.listObjectModel['searchInput'].value = valueFilter;
}

document.addEventListener('DOMContentLoaded', function () {
    wpdaTableList = new wpdaTableMaker('wpda_table_container');
})