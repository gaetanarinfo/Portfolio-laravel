@include('emails/header')

<table class="heading_block block-3" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation"
    style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
    <tr>
        <td class="pad"
            style="padding-bottom:10px;padding-left:20px;padding-right:20px;text-align:center;width:100%;">
            <h5
                style="margin: 0; color: #ffffff; direction: ltr; font-family: Georgia, Times, Times New Roman, serif; font-size: 26px; font-weight: normal; letter-spacing: normal; line-height: 150%; text-align: left; margin-top: 0; margin-bottom: 0;">
                <strong>Merci pour votre paiement.</strong><br>
            </h5>
        </td>
    </tr>
</table>

<table class="text_block block-4" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation"
    style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;">
    <tr>
        <td class="pad" style="padding-left:20px;padding-right:10px;padding-top:10px;">
            <div style="font-family: sans-serif">
                <div class
                    style="font-size: 16px; font-family: Georgia, Times, Times New Roman, serif; mso-line-height-alt: 21.6px; color: #ffffff; line-height: 1.8;">
                    <p style="margin: 0; font-size: 14px; mso-line-height-alt: 28.8px;">
                        <ul>
                            <li><strong>Moyen de paiement</strong> : {{ $orders['order_method'] }}</li>
                            <li><strong>Date du paiement</strong> : {{ date('d/m/Y à H:i', strtotime($orders['order_at'])) }}</li>
                            <li><strong>Total</strong> : {{ $orders['price'] }} €</li>
                        </ul>

                        <p>L'application que vous avez choisi :</p>

                        <ul>
                            <li><strong>Nom</strong> : {{ $projet['title'] }}</li>
                            <li><strong>Prix</strong> : {{ number_format($projet['prix'], 2, ',', '') }} €</li>
                        </ul>

                    </p>
                </div>
            </div>
        </td>
    </tr>
</table>

<table class="text_block block-4" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation"
    style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;">
    <tr>
        <td class="pad" style="padding-left:20px;padding-right:10px;padding-top:10px;">
            <div style="font-family: sans-serif">
                <div class
                    style="font-size: 16px; font-family: Georgia, Times, Times New Roman, serif; mso-line-height-alt: 21.6px; color: #ffffff; line-height: 1.8;">
                    <p style="margin: 0; font-size: 14px; mso-line-height-alt: 28.8px;">
                        Vous ne pouvez pas faire de demande de remboursement. L'achat est définitif en raison des prix pratiqués.
                    </p>
                </div>
            </div>
        </td>
    </tr>
</table>

<table class="text_block block-4" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation"
    style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;">
    <tr>
        <td class="pad" style="padding-left:20px;padding-right:10px;padding-top:10px;">
            <div style="font-family: sans-serif">
                <div class
                    style="font-size: 16px; font-family: Georgia, Times, Times New Roman, serif; mso-line-height-alt: 21.6px; color: #ffffff; line-height: 1.8;">
                    <p style="margin: 0; font-size: 14px; mso-line-height-alt: 28.8px;">
                    <h4><b>Cordialement</b></h4>
                    </p>
                </div>
            </div>
        </td>
    </tr>
</table>

@include('emails/footer')
