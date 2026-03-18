import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { AiService } from '../../services/ai.service';

@Component({
  selector: 'app-ai-chat',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './ai-chat.component.html',
  styleUrls: ['./ai-chat.component.css']
})
export class AiChatComponent {
  message = '';
  answer = '';
  loading = false;
  error = '';

  constructor(private aiService: AiService) {}

  send(): void {
    const trimmedMessage = this.message.trim();

    if (!trimmedMessage) {
      this.error = 'Írj be egy kérdést.';
      return;
    }

    this.loading = true;
    this.error = '';
    this.answer = '';

    this.aiService.sendMessage(trimmedMessage).subscribe({
      next: (res) => {
        this.answer = this.extractText(res);
        this.loading = false;
      },
      error: (err) => {
        console.error('AI hiba:', err);
        this.error = 'Hiba történt az AI válasz lekérésekor.';
        this.loading = false;
      }
    });
  }

  private extractText(res: any): string {
    if (res?.output_text) {
      return res.output_text;
    }

    if (Array.isArray(res?.output)) {
      const texts = res.output
        .flatMap((item: any) => item.content || [])
        .filter((content: any) => content.type === 'output_text' || content.type === 'text')
        .map((content: any) => content.text)
        .filter(Boolean);

      if (texts.length) {
        return texts.join('\n');
      }
    }

    return 'Nincs értelmezhető válasz.';
  }
}
