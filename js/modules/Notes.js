import $ from 'jquery';

class myNotes {
    constructor() {
        this.editBtn = $(".edit-note");
        this.deleteBtn = $(".delete-note");
        this.updateBtn = $(".update-note");
        this.editMode = false;
        this.noteTitle;
        this.noteContent;
        this.noteContent;
        this.events();
    }

    events() {
        this.editBtn.on("click", this.editNote.bind(this));
        this.deleteBtn.on("click", this.deleteNote);
        this.updateBtn.on("click", this.updateNote.bind(this));
    }

    editNote(e) {
        var thisNote = $(e.target).parents("li");

        if (thisNote.data("state") == "editable") {
            thisNote.children(".note-title-field").val(this.noteTitle);
            thisNote.children(".note-body-field").val(this.noteContent);
            this.makeNoteReadOnly(thisNote);
        } else {
            this.noteTitle = thisNote.children(".note-title-field").val();
            this.noteContent = thisNote.children(".note-body-field").val();
            this.makeNoteEditable(thisNote);
        }
        
    }

    makeNoteEditable(thisNote) {
        thisNote.find('.note-title-field, .note-body-field').removeAttr("readonly").addClass("note-active-field");
        thisNote.find('.update-note').addClass("update-note--visible");
        thisNote.find('.edit-note').html('<i class="fa fa-times" aria-hidden="true"></i> Cancel');
        thisNote.data("state", "editable");
    }

    makeNoteReadOnly(thisNote) {
        thisNote.find('.note-title-field, .note-body-field').attr("readonly", "readonly").removeClass("note-active-field");
        thisNote.find('.update-note').removeClass("update-note--visible");
        thisNote.find('.edit-note').html('<i class="fa fa-pencil" aria-hidden="true"></i> Edit');
        thisNote.data("state", "cancel");
    }

    deleteNote(e) {
        var thisNote = $(e.target).parents("li");

        $.ajax({
            beforeSend: (xhr) => {
                xhr.setRequestHeader('X-WP-Nonce', universityData.nonce)
            },
            url: universityData.root_url + '/wp-json/wp/v2/note/' + thisNote.data('id'),
            type: 'DELETE',
            success: (response) => {
                thisNote.slideUp();
                console.log('congrats');
                console.log(response);
            },
            error: (response) => {
                console.log('sorry');
                console.log(response);
            }
        })
    }

    updateNote(e) {
        var thisNote = $(e.target).parents("li");
        var ourUpdateNote = {
            'title': thisNote.find(".note-title-field").val(),
            'content': thisNote.find(".note-body-field").val()
        }

        $.ajax({
            beforeSend: (xhr) => {
                xhr.setRequestHeader('X-WP-Nonce', universityData.nonce)
            },
            url: universityData.root_url + '/wp-json/wp/v2/note/' + thisNote.data('id'),
            type: 'POST',
            data: ourUpdateNote,
            success: (response) => {
                this.makeNoteReadOnly(thisNote);
                console.log('congrats');
                console.log(response);
            },
            error: (response) => {
                console.log('sorry');
                console.log(response);
            }
        })
    }

}

export default myNotes;