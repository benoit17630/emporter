function createSelect(array) {

    const div = document.createElement('div') //je cree une div pour mettre les selects dedans

    div.append('Selectionner: ')

    const select = document.createElement('select') //creation du select
    select.className = 'col-7 my-3'
    for (const category of array) {

        const optgroup = document.createElement('optgroup'); //creation des optgroupe
        optgroup.label = category.name

        for (const pizza of category.pizzas) {

            const option = document.createElement('option'); // creation des options
            option.textContent = pizza.name + " " + pizza.price + "€";
            optgroup.append(option)

        }

        select.append(optgroup)
    }

    div.append(select)

    return div;
}
//creation de la function d affichage avec un number
function affichage(array) {
    const nb = document.createElement('input');
    nb.type = 'number'
    nb.value = 0;
    nb.max = 12;
    nb.min = 0;
    const div = document.createElement('div');
    div.className = 'row py-3'

    let last = 0;

    nb.addEventListener('change', () => {
        const nouveau = parseInt(nb.value);

        for (let i = nouveau; i < last; i++) //pour enlever un select si l utilisateur decide d enlever une pizza
            div.removeChild(div.lastChild);

        for (let i = last; i < nouveau; i++) // pour ajouter un select si l utilisateur decide d ajouter une pizza
            div.append(createSelect(array))

        last = nb.valueAsNumber; //pour redefinir last au nb choisit
    })

    document.getElementById('commande').append(nb, div); //endroit ou l on place
}

fetch('js/api.json') //secret du json
    .then(response => response.json())
    .then(json => {
        affichage(json.array)
    });