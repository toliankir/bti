const $filesListBody = $('#filesList-body');
const $modalFileArticle = $('#modal-file_article');
const $modalFileDescription = $('#modal-file_description');
const $modalFileId = $('#modal-file_id');
const $modalFilename = $('#modal-file_name');

function fillFileListTable() {
    ajaxRequest('GET', {
        'action': 'getAllFiles',
    }, (response) => {
        $filesListBody.html('');
        response.body.forEach((item) => {
            const fileExtension = item.filename.split('.').pop();

            $filesListBody.append(
                $('<tr></tr>')
                    .append($(`<td><img class='icon-file-configurator' src="${assetsLink}/fileicons/${fileExtension}.svg"><a traget=_blank href="${uploadFileLink}/${item.filename}">${item.filename}</a></td>`))
                    .append($(`<td>${item.article}</td>`))
                    .append($(`<td>${item.title}</td>`))
                    .append($(`<td>${item.description}</td>`))
                    .append($(`<td>${item.state}</td>`))
                    .append($(`<td></td>`)
                        .append($('<button class="btn btn-success mr-2" data-toggle="modal" data-target="#fileModal">Edit</button>')
                            .on('click', () => {
                                $modalFileArticle.val(item.article);
                                $modalFileDescription.val(item.description);
                                $modalFileId.val(item.id === '' ? 0 : item.id);
                                $modalFilename.val(item.filename);
                            }))
                        .append(item.state === 'Filesystem' ? $('<button class="btn btn-danger">Удалить с ФС</button>')
                            .on('click', () => {
                                ajaxRequest('GET', {
                                    action: 'unlinkFile',
                                    file: item.filename
                                }, () => {
                                    fillFileListTable();
                                })
                            }) : '')
                        .append(item.state === 'Base' ? $('<button class="btn btn-danger">Удалить с БД</button>')
                            .on('click', () => {
                                ajaxRequest('GET', {
                                    action: 'deleteFileFromDB',
                                    file: item.filename
                                }, () => {
                                    fillFileListTable();
                                })
                            }) : '')
                    )
            );
        });
    });
}

function filesConfigurator() {
    fillFileListTable();
}