<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use App\Models\Article;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;
use App\Models\Comment;

class Commentmail extends Mailable
{
    use Queueable, SerializesModels;

    public Comment $comment;
    public Article $article;

    /**
     * Create a new message instance.
     */
    public function __construct(Comment $comment, Article $article)
    {
        $this->comment = $comment;
        $this->article = $article;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME')), 
            subject: 'Новый комментарий к статье: ' . $this->article->title,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.comment',
            with: [
                'comment' => $this->comment,
                'article_title'=>$this->article->title,
                'author' => $this->comment->user->name, // используем связь с пользователем
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}