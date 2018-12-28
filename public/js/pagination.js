class Pagination {
    constructor(element, options = {}) {
        this.element = element;
        this.options = Object.assign({}, {
            show_per_page : 1,
            current_page: 0
        }, options);

        // Création d'un array avec les enfants de this.element
        this.children = [].slice.call(element.children);
        console.log(this.children);
        // Recuperation du nombre d'items dans children, ici 4
        this.items = this.children.length;

        this.setStyle(0, this.options.show_per_page);
        this.createPagination();

        let buttonPagination = [].slice.call(document.querySelectorAll('.page-link'));
        buttonPagination.map((child) =>{
            child.addEventListener('click', ()=>{
                this.go_to_page(child.classList[1]);
            })
        });
    }

    number_of_pages() {
        return( Math.ceil(this.items / this.options.show_per_page));
    }

    setStyle(first, last) {
        this.children.forEach(child => {
            child.style.display = "none";
        });
        this.children.slice(first, last).forEach(child => {
            child.style.display = "flex";
        })
    }

    createPagination() {
        let ul = document.createElement('ul');
        ul.setAttribute('class', 'pagination');
        ul.classList.add("justify-content-center");
        let i = -1;
        while(this.number_of_pages() > ++i){
            let li = document.createElement('li');
            li.setAttribute('class', 'page-item');
            if (!i) {
                li.classList.add("active");
            }
            let link = document.createElement('a');
            link.setAttribute('class', 'page-link');
            link.classList.add('' + i + '');
            link.innerHTML = i+1;

            li.setAttribute('id', 'id'+i);
            li.appendChild(link);
            ul.appendChild(li);
        }

        // Container pour la pagination
        document.querySelector('#container_navigation').appendChild(ul);
    }


    go_to_page(page_num) {
        this.options.current_page = page_num;
        let start = this.options.current_page * this.options.show_per_page;
        let end = start + this.options.show_per_page;
        this.setStyle(start, end);
        document.querySelector('li.active').classList.remove('active');
        document.getElementById('id' + page_num).classList.add('active');
    }

}

document.addEventListener('DOMContentLoaded', function() {
    if (document.querySelector('#container_comment_js') != null) {
        new Pagination(document.querySelector('#container_comment_js'), {
            show_per_page : 3,
            current_page: 0,
        });
    }

    if (document.querySelector('#container_trick_js') != null) {
        new Pagination(document.querySelector('#container_trick_js'), {
            show_per_page : 8,
            current_page: 0,
        });
    }

});